<?php
// * Make sure config.php exists before loading it
if(file_exists("config.php")) {
	include "config.php";
} else {
	print('ERROR: Before using this script, copy config.php-dist to config.php and customize it.');
	exit();
}

// * Explicitly advertise that this is XML so browsers don't style it
if (!isset($_GET['test'])){
	header('Content-type: application/atom+xml; charset=utf-8');
}

// * Fetch $count from the URL if the user supplied it
if (isset($_GET["count"])) {
	if (is_int(intval($_GET["count"]))) {
		$session_count = intval( $_GET["count"] );
	}
}

// * Now, based on what variables are in the URL, pick the type
// * Of query we're going to do.
// *
// * Note these use the ternary operator (?:) to keep things short.
// * It works like: (if this is true) ? (then return this) : (else return this)
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
