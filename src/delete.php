<?php

	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "delete.php";
	
	if (isset($_SESSION['username'])) {

		$conn = mysql_connect($config['dbaddr'], $config['dbuser'], $config['dbpass']);
		mysql_select_db($config['dbname'], $conn);

		$row0 = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "'", $conn));

		if ($row0['authtoken'] == $_SESSION['authtoken']) {

		}
		
	}

	if (isset($_SESSION['previous'])) {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=" . $_SESSION['previous'] . "\">";
	} else {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\">";
	}

?>