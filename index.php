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

if (isset($_GET["count"])) {
	if (is_int(intval($_GET["count"]))) {
		$session_count = intval( $_GET["count"] );
	}
}

if (isset( $_GET["screen_name"])) {
	$screen_name = htmlspecialchars($_GET["screen_name"]);
	$count = isset($session_count) ? $session_count : $user_count;
	include "user.php";
} elseif (isset($_GET["list"])) {
	$list = htmlspecialchars($_GET["list"]);
	$count = isset($session_count) ? $session_count : $list_count;
	if(isset($_GET["owner"])) {
		$owner = htmlspecialchars($_GET["owner"]);
	} else {
		$owner = $screen_name;
	}
	include "list.php";
} elseif (isset( $_GET["q"] )) {
	$q = $_GET["q"];
	$count = isset($session_count) ? $session_count : $search_count;
	include "search.php";
} else { // Default to home
	$count = isset($session_count) ? $session_count : $home_count;
	include "home.php";
}
?>
