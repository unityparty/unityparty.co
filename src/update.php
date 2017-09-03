<?php

	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "update.php";

	include("template.php");

	$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'"));

	if (isset($_SESSION['authtoken']) && $_SESSION['authtoken'] == $user['authtoken']) {

		if (isset($_POST['nickname'])) {
			
			if ($_POST['nickname'] == $user['username']) {

				$query = mysqli_query($conn, "UPDATE `users` SET `nickname` = null WHERE `id` = " . mysqli_real_escape_string($conn, $user['id']));

			} elseif ($_POST['nickname'] !== $user['nickname']) {

				if (strpos($_POST['nickname'], "<script") !== FALSE) {
						echo "<p>Scripts not allowed.</p>";
					} else {

						if (!containsHTML($_POST['nickname'])) {
							$query = mysqli_query($conn, "UPDATE `users` SET `nickname` = '" . mysqli_real_escape_string($conn, $_POST['nickname']) . "' WHERE `id` = " . mysqli_real_escape_string($conn, $user['id']));
						}

					}

			}

		}

		if (isset($_POST['description'])) {

			if ($_POST['description'] !== $user['description']) {
				if (!containsHTML($_POST['description'])) {
					if (strpos($_POST['description'], "<script") == FALSE) {
						$description = bbParse($_POST['description']);
						$query = mysqli_query($conn, "UPDATE `users` set `description` = '" . mysqli_real_escape_string($conn, $description) . "' WHERE `id` = " . $user['id']);
					} 
				}
			}

		}

	}

	mysqli_close($conn);

	if (isset($_SESSION['previous'])) {
		header('Location: ' . $_SESSION['previous']);
	} else {
		header('Location: index.php');	
	}

?>