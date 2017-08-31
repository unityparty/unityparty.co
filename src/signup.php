<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "signup.php";

	include('includes/Mobile-Detect/Mobile_Detect.php');
	include('config.php');

	$client = new Mobile_Detect();
	if ($client->isMobile()) {
		if (!isset($_SESSION['view'])) {
			$_SESSION['view'] = 'mobile';
		}
	}
?>

<!DOCTYPE html>
<html>

	<head>

		<title>Unity Party | Sign Up</title>
		<?php
			if ($_SESSION['view'] == 'mobile') {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/mobilemain.css\" />";
			} else {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/main.css\" />";
			}
		?>

	</head>

	<body>

		<div class="NOTICE">
			<?php 
				echo "<b>" . $config['notice'] . "</b>";
			?>
		</div>

		<div class="BANNER">
			<a href="index.php"><img src="assets/images/banner.png" width=100% /></a>
		</div>

		<div class="MENU">
			<table><tr>
				<td><a href="index.php">News</a></td>
				<td><a href="about.php">About</a></td>
				<td><a href="join.php">Join</a></td>
				<td><a href="donate.php">Donate</a></td>
				<td><a href="volunteer.php">Volunteer</a></td>
			</tr></table>
		</div>

		<div class="USERMENU">
			<?php
				if (!isset($_SESSION['username'])) {
					echo "<a href=\"signup.php\" class=\"uselected\">Sign up</a>";
					echo "<a href=\"login.php\">Log in</a>";
				} else {
					echo "<a href=\"member.php?username=" . $_SESSION['username'] . "\">" . $_SESSION['username'] . "</a>";
					echo "<a href=\"forum.php\">Forums</a>";
					echo "<a href=\"member.php\">Members</a>";
					echo "<a href=\"signout.php\">Sign out</a>";
				}
			?>
		</div>

		<div class="MAIN">

			<?php

				if (!isset($_SESSION['username'])) {

					if (isset($_POST['username'])) {
						$conn = mysql_connect($config['dbaddr'], $config['dbuser'], $config['dbpass']);
					mysql_select_db($config['dbname'], $conn);

						$username = $_POST['username'];
						$password = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);

						$query = mysql_query("SELECT * FROM `users`");
						$found = 0;
						while ($row = mysql_fetch_assoc($query)) {

							if ($row['username'] == $username) {
								$found = 1;
							}

						}

						if (!$found) {

							$authtoken = rand(0, 999999999);
							
							$query = mysql_query("INSERT INTO `users` (`id`, `username`, `password`, `authtoken`, `nickname`, `description`, `admin`, `writer`) VALUES (NULL, '" . $username . "', '" . $password . "', '" . $authtoken . "', NULL, NULL, '0', '0')", $conn);
							$_SESSION['username'] = $username;
							$_SESSION['authtoken'] = $authtoken;
							echo "Successful";
							echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" />";

						} else {
							echo "Username already in use.";
						}

						mysql_close($conn) or die();

					} else {
						echo "<form action=\"signup.php\" method=\"POST\">";
						echo "<input type=\"text\" name=\"username\" placeholder=\"Username\" /><br />";
						echo "<input type=\"password\" name=\"password\" placeholder=\"Password\" /><br />";
						echo "<input type=\"submit\" value=\"Sign up\" />";
						echo "</form>";
					}
				} else {
					echo "Already signed in";
				}

			?>

		</div>

		<div class="FOOTER">
			<?php 
				if ($_SESSION['view'] == 'mobile') {
					echo "<a href=\"mobileview.php\">Desktop view</a>";
				} else {
					echo "<a href=\"mobileview.php\">Mobile view</a>";
				}
			?>
			<a href="credit.php">Credit</a>
		</div>

	</body>

</html>