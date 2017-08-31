<?php

	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "signout.php";

	include('config.php');

	$conn = mysql_connect($config['dbaddr'], $config['dbuser'], $config['dbpass']);
	mysql_select_db($config['dbname'], $conn);

	$query = mysql_query("UPDATE `users` SET `authtoken` = NULL WHERE `username` = '" . $_SESSION['username'] . "'", $conn);



	mysql_close($conn);

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
		echo "<meta http-equiv=\"refresh\" content=\"0; url=" . $previous . "\" />";
	} else {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" />";
	}

?>