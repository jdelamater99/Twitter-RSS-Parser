<?php
//v1.1

/**
 * Make sure config.php exists before loading it
 */
if(file_exists("config.php")) {
	include "config.php";
} else {
	print('ERROR: Before using this script, copy config.php-dist to config.php and customize it.');
	exit();
}

if (!isset($_GET['test'])){
	header('Content-type: application/atom+xml; charset=utf-8');
}

if ( $list != NULL ){	
	include "list.php";
} else if ( $home ) {
	include "home.php";
} else if ( $search ) {
	include "search.php";
} else {
	include "user.php";
}

?>
