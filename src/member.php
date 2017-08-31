<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "member.php";

	include("config.php");
	include ('includes/Mobile-Detect/Mobile_Detect.php');
	
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

		<title>Unity Party | Member</title>
		<?php
			if ($_SESSION['view'] == 'mobile') {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/mobilemain.css\" />";
			} else {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/main.css\" />";
			}
		?>

	</head>

	<body>

		<?php
			if (!is_null($config['notice'])) {
				echo "<div class=\"NOTICE\">";
				echo "<b>" . $config['notice'] . "</b>";
				echo "</div>";
			}
		?>

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
					echo "<a href=\"signup.php\">Sign up</a>";
					echo "<a href=\"login.php\">Log in</a>";
				} else {
					echo "<a href=\"member.php?username=" . $_SESSION['username'] . "\">" . $_SESSION['username'] . "</a>";
					echo "<a href=\"forum.php\">Forums</a>";
					echo "<a href=\"member.php\" class=\"uselected\">Members</a>";
					echo "<a href=\"signout.php\">Sign out</a>";
				}
			?>
		</div>

		<div class="MAIN">

			<?php 

				if (isset($_GET['username'])) {
					
					$conn = mysql_connect($config['dbaddr'], $config['dbuser'], $config['dbpass']);
					mysql_select_db($config['dbname'], $conn);

					$query = mysql_query("SELECT * FROM `users`", $conn);

					$found = 0;
					while ($row = mysql_fetch_assoc($query)) {
						if ($row['username'] == $_GET['username']) {
							$found = 1;

							if (isset($row['nickname'])) {
								echo "<p><b style=\"font-size: 1.5em;\">" . $row['nickname'] . "</b><br />";
								echo "@" . $row['username'] . "#" . $row['id'];
								echo "</p>";
							} else {
								echo "<p><b style=\"font-size: 1.5em;\">" . $row['username'] . "</b><br />";
								echo "@" . $row['username'] . "#" . $row['id'];
								echo "</p>";
							}

							echo "<p>" . $row['description'] . "</p>";

							if ($_SESSION['username'] == $row['username']) {
								echo "<br /><hr />";
								if ($_SESSION['authtoken'] == $row['authtoken']) {
									echo "Valid authentication token";
								} else {
									echo "<p>Invalid authentication token</p>";
								}
							}
						}
					}

					if (!$found) {
						echo "User " . $_GET['username'] . " not found.";
					}

					mysql_close($conn);

				} else {
					echo "Still working on it (you can view specific profiles, though).";
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