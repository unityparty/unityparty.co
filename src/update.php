<?php

	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "update.php";

	include("config.php");

	$conn = mysqli_connect($config['dbaddr'], $config['dbuser'], $config['dbpass'], $config['dbname']);

	$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'"));

	if (isset($_SESSION['authtoken']) && $_SESSION['authtoken'] == $user['authtoken']) {

		if (isset($_POST['nickname'])) {
			
			if ($_POST['nickname'] == $user['username']) {

				$query = mysqli_query($conn, "UPDATE `users` SET `nickname` = null WHERE `id` = " . mysqli_real_escape_string($conn, $user['id']));

			} elseif ($_POST['nickname'] !== $user['nickname']) {

				if (strpos($_POST['nickname'], "<script") !== FALSE) {
						echo "<p>Scripts not allowed.</p>";
					} else {

						$query = mysqli_query($conn, "UPDATE `users` SET `nickname` = '" . mysqli_real_escape_string($conn, $_POST['nickname']) . "' WHERE `id` = " . mysqli_real_escape_string($conn, $user['id']));

					}

			}

		}

		if (isset($_POST['description'])) {

			if ($_POST['description'] !== $user['description']) {

				if (strpos($_POST['description'], "<script") !== FALSE) {
						echo "<p>Scripts not allowed.</p>";
					} else {
		
						$query = mysqli_query($conn, "UPDATE `users` set `description` = '" . mysqli_real_escape_string($conn, $_POST['description']) . "' WHERE `id` = " . $user['id']);

					}
			}

		}

	}

	mysqli_close($conn);

	if (isset($_SESSION['previous'])) {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=" . $_SESSION['previous'] . "\" />";
	} else {
		echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" />";
	}

?>