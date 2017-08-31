<?php

	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "delete.php";

	include('config.php');
	
	if (isset($_SESSION['username'])) {

		$conn = mysql_connect($config['dbaddr'], $config['dbuser'], $config['dbpass']);
		mysql_select_db($config['dbname'], $conn);

		$query = mysql_query("SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "'", $conn);
		$row = mysql_fetch_assoc($query);

		if ($row['authtoken'] == $_SESSION['authtoken']) {
			$query = mysql_query("DELETE FROM `news` WHERE `id` = " . $_GET['article'], $conn);
		} else {
			echo "FAILURE";
		}
		
	}

	if (isset($_SESSION['previous'])) {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=" . $_SESSION['previous'] . "\">";
	} else {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
	}

?>