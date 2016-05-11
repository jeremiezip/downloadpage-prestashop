<?php 

/* Init */
$sql_requests = array();
$sql_requests[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'download_module`;';
$sql_requests[] = 'DROP TABLE IF EXISTS `'._DB_PREFIX_.'download_module_lang`;';
