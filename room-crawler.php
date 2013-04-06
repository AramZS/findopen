<?php

mb_language('uni');
mb_internal_encoding('UTF-8');
require_once('simple_html_dom.php');
$dom = new simple_html_dom;

$contentHtml = file_get_html();

$contentHtml = file_get_html('http://localhost:8080/xampp/findopen/tables.html');
//set_error_handler("customError");

foreach ($html->find('table') as $table){
	$c = 0;
	foreach ($table->find('tr') as $row){
	
		if ($c > 1){
			
		}
		$c++;
	
	}

}