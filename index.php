<?php
//v.8

include "config.php";

if ( $list != NULL ){	
	include "list.php";
} else {
	include "user.php";
}

?>