<?php

	session_start();

	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "mobileview.php";

	if ($_SESSION['view'] == 'mobile') {
		$_SESSION['view'] = 'desktop';
	} else {
		$_SESSION['view'] = 'mobile';
	}

	header('Location: ' . $_SESSION['previous']);

?>