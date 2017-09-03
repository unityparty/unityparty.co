<?php

	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "signout.php";

	include('config.php');

	$conn = mysqli_connect($config['dbaddr'], $config['dbuser'], $config['dbpass'], $config['dbname']);

	$query = mysqli_query($conn, "UPDATE `users` SET `authtoken` = NULL WHERE `username` = '" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'");



	if (isset($_SESSION['view'])) {
		$view = $_SESSION['view'];
	}
	if (isset($_SESSION['previous'])) {
		$previous = $_SESSION['previous'];
	}

	session_unset();
	session_destroy();

	session_start();
	$_SESSION['view'] = $view;

	if (isset($previous)) {
		header('Location: ' . $_SESSION['previous']);
	} else {
		header('Location: index.php');
	}

?>