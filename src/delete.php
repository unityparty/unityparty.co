<?php

	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "delete.php";

	include('config.php');
	
	if (isset($_SESSION['username'])) {

		$conn = mysqli_connect($config['dbaddr'], $config['dbuser'], $config['dbpass'], $config['dbname']);

		$query = mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'");
		$row = mysqli_fetch_assoc($query);

		$article = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `news` WHERE `id` = " . mysqli_real_escape_string($conn, $_GET['article'])));

		if ($row['authtoken'] == $_SESSION['authtoken']) {

			if (isset($_GET['article'])) {

				if ($row['username'] == $article['author'] || $row['admin']) {

					$query = mysqli_query($conn, "DELETE FROM `news` WHERE `id` = " . mysqli_real_escape_string($conn, $_GET['article']));
				}

				if (isset($_SESSION['previous'])) {
					header('Location: ' . $_SESSION['previous']);
				} else {
					header('Location: index.php');
				}
			} elseif ($_POST['method'] == "user") {

				if (password_verify($_POST['password'], $row['password'])) {
					echo "password correct";
				}

			}

		} else {
			echo "FAILURE";
		}
		
	}

?>