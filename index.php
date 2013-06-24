<?php
//v1.0

include "config.php";

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
