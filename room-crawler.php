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
		if ($c > 1){
			$dc = 0;
			foreach ($row->find('td') as $td) {
				if ($dc != 1 && $dc != 2){
					$qstring .= "'";
					$qstring .= $td->innertext;
					$qstring .= "', ";
				}
				if ($dc == 2){
					# Case for finding or building the building entry in the database based on the string. 
					$result = pg_query($dbconn, 
						"INSERT INTO films (code, title, did, date_prod, kind) " 
						. "VALUES ('T_601', 'Yojimbo', 106, '1961-06-16', 'Drama');");					
				}
				$dc++;
			}
		}
		$qstring .= ");";	
		$c++;
		$result = pg_query($dbconn, $qstring);
	}

}