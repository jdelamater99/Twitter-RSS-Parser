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

if (isset( $_GET["count"] ))
        $count = intval( $_GET["count"] );

$count = htmlspecialchars($count);
$screen_name = $twit_name;

if (isset( $_GET["screen_name"])) {
	$screen_name = htmlspecialchars($_GET["screen_name"]);
	$sn = $screen_name;
	$count = $user_count;
	include "user.php";
} elseif (isset($_GET["list"])) {
	$list = htmlspecialchars($_GET["list"]);
	$count = $list_count;
	if(isset($_GET["owner"])) {
		$owner = htmlspecialchars($_GET["owner"]);
	} else {
		$owner = $twit_name;
	}
	include "list.php";
} elseif (isset( $_GET["q"] )) {
	$q = $_GET["q"];
	include "search.php";
} else { // Default to home
	$sn = $screen_name;
	$count = $home_count;
	include "home.php";
}
?>
