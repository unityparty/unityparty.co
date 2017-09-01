<?php

	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "update.php";

	include("config.php");

	$conn = mysql_connect($config['dbaddr'], $config['dbuser'], $config['dbpass']);
	mysql_select_db($config['dbname'], $conn);

	$user = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "'"));

	if (isset($_SESSION['authtoken']) && $_SESSION['authtoken'] == $user['authtoken']) {

		if (isset($_POST['nickname'])) {
			
			if ($_POST['nickname'] == $user['username']) {

				$query = mysql_query("UPDATE `users` SET `nickname` = null WHERE `id` = " . $user['id']);

			} elseif ($_POST['nickname'] !== $user['nickname']) {

				if (strpos($_POST['nickname'], "<script") !== FALSE) {
						echo "<p>Scripts not allowed.</p>";
					} else {

						$query = mysql_query("UPDATE `users` SET `nickname` = '" . mysql_real_escape_string($_POST['nickname']) . "' WHERE `id` = " . $user['id']);

					}

			}

		}

		if (isset($_POST['description'])) {

			if ($_POST['description'] !== $user['description']) {

				if (strpos($_POST['description'], "<script") !== FALSE) {
						echo "<p>Scripts not allowed.</p>";
					} else {
		
						$query = mysql_query("UPDATE `users` set `description` = '" . mysql_real_escape_string($_POST['description']) . "' WHERE `id` = " . $user['id']);

					}
			}

		}

	}

	mysql_close($conn);

	if (isset($_SESSION['previous'])) {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=" . $_SESSION['previous'] . "\" />";
	} else {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" />";
	}

?>