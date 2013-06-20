<?php
//v.9

include "config.php";

if ( $list != NULL ){	
	include "list.php";
} else if ( $home ) {
	include "home.php";
} else {
	include "user.php";
}

?>