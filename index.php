<?php
//v.7

include "config.php";

if (!isset( $_GET["owner"] ))
	$_GET["owner"] = $_GET["screen_name"];
	
if (!isset( $_GET["count"] ))
	$_GET["count"] = "5";

$sn = htmlspecialchars($_GET["screen_name"]);
$owner = htmlspecialchars($_GET["owner"]);
$cnt = htmlspecialchars($_GET["count"]);

if ( isset($_GET["list"]) ){
	$list = htmlspecialchars($_GET["list"]);
	
	include "list.php";
} else {
	include "user.php";
}

?>