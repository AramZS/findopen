<?php

mb_language('uni');
mb_internal_encoding('UTF-8');
require_once('simple_html_dom.php');
$dom = new simple_html_dom;

$contentHtml = file_get_html();