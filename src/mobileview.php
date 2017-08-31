<?php

	session_start();

	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "mobileview.php";

	if ($_SESSION['view'] == 'mobile') {
		$_SESSION['view'] = 'desktop';
	} else {
		$_SESSION['view'] = 'mobile';
	}

	echo "<meta http-equiv=\"refresh\" content=\"0; url=" . $_SESSION['previous'] . "\" />";

?>