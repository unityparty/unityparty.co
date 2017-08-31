<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "forum.php";

	include('config.php');
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

		<title>Unity Party | Forum</title>
		<?php
			if ($_SESSION['view'] == 'mobile') {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/mobilemain.css\" />";
			} else {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/main.css\" />";
			}
		?>
		<link rel="stylesheet" type="text/css" href="assets/css/forum.css" />

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
					echo "<a href=\"signup.php\">Sign up</a>";
					echo "<a href=\"login.php\">Log in</a>";
				} else {
					echo "<a href=\"member.php?username=" . $_SESSION['username'] . "\">" . $_SESSION['username'] . "</a>";
					echo "<a href=\"forum.php\" class=\"uselected\">Forums</a>";
					echo "<a href=\"member.php\">Members</a>";
					echo "<a href=\"signout.php\">Sign out</a>";
				}
			?>
		</div>

		<div class="MAIN">
			<p>Coming soon.</p><hr />

			<?php

				$conn = mysql_connect($config['dbaddr'], $config['dbuser'], $config['dbpass']);
				mysql_select_db($config['dbname'], $conn);

				if (isset($_GET['forum'])) {

					echo "<div class=\"category\">";

					$query0 = mysql_query("SELECT * FROM `forums`");
					while ($row0 = mysql_fetch_assoc($query0)) {
						if ($row0['id'] == $_GET['forum']) {
							if (!is_null($row0['parent'])) {
								echo "<p><b style=\"font-size: 1.5em\">" . $row0['name'] . "</b><br />" . $row0['description'] . "</p>";

								$query1 = mysql_query("SELECT * FROM `threads` ORDER BY `id` DESC");
								while ($row1 = mysql_fetch_assoc($query1)) {
									if ($row1['forum'] == $_GET['forum']) {
										if (is_null($row1['parent'])) {
											echo "<div class=\"threadl\">";
											echo "<p><b><a href=\"?thread=" . $row1['id'] . "\">" . $row1['title'];
											echo "</a></b> by " . $row1['author'] . "</p></div>";
										}
									}
								}
							} else {
								//category
							}
						}
					}

					echo "<a href=\"forum.php\">Return to forums</a>";
					echo "</div>";

				} elseif (isset($_GET['thread'])) {

					$query = mysql_query("SELECT * FROM `threads`");
					
					echo "<div class=\"category\">";

					while ($row = mysql_fetch_assoc($query)) {
						if ($row['id'] == $_GET['thread']) {
							echo "<p><b>" . $row['title'] . "</b> by <a href=\"member.php?username=" . $row['author'] . "\">" . $row['author'] . "</a><br />" . $row['content'] . "</p>";
						}
					}

					echo "</div>";

					$query = mysql_query("SELECT * FROM `threads`");
					while ($row = mysql_fetch_assoc($query)) {
						if ($row['parent'] == $_GET['thread']) {
							echo "<div class=\"category\">";
							echo "<p>" . $row['content'] . "</p><p>by <a href=\"member.php?username=" . $row['author'] . "\">" . $row['author'] . "</a></p>";
							echo "</div>";
						}
					}

				} else {

					$query = mysql_query("SELECT * FROM `forums`");

					while ($row0 = mysql_fetch_assoc($query)) {
						if (is_null($row0['parent'])) {
							echo "<div class=\"category\">";
							echo "<p><b style=\"font-size: 1.5em;\">" . $row0['name'] . "</b><br />" . $row0['description'] . "</p>";

							while ($row1 = mysql_fetch_assoc($query)) {
								if ($row1['parent'] == $row0['id']) {
									echo "<div class=\"foruml\">";
									if (!is_null($row1['description'])) {
										echo "<p><b><a href=\"?forum=" . $row1['id'] . "\">" . $row1['name'] . "</a></b> - " . $row1['description'] . "</p>";
									} else {
										echo "<p><b><a href=\"?forum=" . $row1['id'] . "\">" . $row1['name'] . "</a></b></p>";
									}
									echo "</div>";
								}
							}

							echo "</div>";
						}
					}
				}

				mysql_close($conn);

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