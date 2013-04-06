<?php
	
mb_language('uni');
mb_internal_encoding('UTF-8');
require_once('simple_html_dom.php');
$dom = new simple_html_dom;

$html = file_get_html('http://localhost:8080/xampp/findopen/tables.html');
//set_error_handler("customError");

$dbconn = pg_connect("host=localhost dbname=publishing user=www password=foo")
    or die('Could not connect: ' . pg_last_error());

foreach ($html->find('table') as $table){
	$c = 0;
	foreach ($table->find('tr') as $row){
		$qstring = "INSERT INTO room (id, room_number, building_id, features, layouts, max_capacity)
		VALUES (";
		$qstring .= "'" . $c ."'";
			$dc = 0;
			$bldCode = '';
			foreach ($row->find('td') as $td) {
				if ($dc > 1 && $dc != 3 && $dc != 4){
					$qstring .= "'";
					$qstring .= $td->innertext;
					$qstring .= "', ";
					if ($dc == 2){
						$barray = explode(" ", $td->innertext);
						$bldCode = $barray[0];
					}
				}
				if ($dc == 4){
					# Case for finding or building the building entry in the database based on the string. 
					$bSelective = pg_select($dbconn, 
						'building',
						array(
							'building_code' => $bldCode
						)
					);
					if (!$bSelective){
						$bqstring = "INSERT INTO building (id, building_code, building_name) VALUES (";
						$bqstring = "'" . $c . "', ";
						$bqstring = "'" . $bldCode . "', ";
						$bqstring = "'" . $td->innertext . "');";
						$bresult = pg_query($dbconn, $bqstring);
		
						$qstring .= "'";
						$qstring .= $c;
						$qstring .= "', ";						
					} else {
						$qstring .= "'";
						$qstring .= $bSelective['id'];
						$qstring .= "', ";
					}
				}
				$dc++;
			}
		$qstring .= ");";	
		$result = pg_query($dbconn, $qstring);
		$c++;		
	}

}