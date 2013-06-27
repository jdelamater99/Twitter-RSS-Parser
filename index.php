<?php
<<<<<<< HEAD
//v1.1
=======
//v1.0
>>>>>>> 5bc7a2493926b74440733016713e66b7e257c9fa

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
