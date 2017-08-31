<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "index.php";

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

		<title>Unity Party | News</title>
		<?php
			if ($_SESSION['view'] == 'mobile') {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/mobilemain.css\" />";
			} else {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/main.css\" />";
			}
		?>
		<link rel="stylesheet" type="text/css" href="assets/css/news.css" />

		<link rel="shortcut icon" href="/assets/images/favicon.ico">

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
				<td><a href="index.php" class="selected">News</a></td>
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
					echo "<a href=\"member.php\">Members</a>";
					echo "<a href=\"signout.php\">Sign out</a>";
				}
			?>
		</div>

		<div class="MAIN">

			<?php 

				$conn = mysql_connect($config['dbaddr'], $config['dbuser'], $config['dbpass']);
				mysql_select_db($config['dbname'], $conn);

				if (!isset($_GET['article'])) {

					if (isset($_SESSION['username'])) {
						$query = mysql_query("SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "'");
						while ($row = mysql_fetch_assoc($query)) {
							if ($row['writer'] == '1') {
							echo "<a href=\"postarticle.php\">Post article</a>";
							}
						}
					}

					$query = mysql_query("SELECT * FROM `news` ORDER BY `id` DESC", $conn);

					while ($row = mysql_fetch_assoc($query)) {
						echo "<div class=\"article\">";
						echo "<p><b class=\"article-title\">" . $row['title'] . "</b> by <a href=\"member.php?username=" . $row['author'] . "\">" . $row['author'] . "</a></p>";
						echo "<p>" . $row['brief'] . "</p>";
						echo "<p>Click <a href=\"?article=" . $row['id'] . "\">here</a> to read more.</p>";
						echo "</div><hr />";

					}

				} else {

					$query = mysql_fetch_assoc(mysql_query("SELECT * FROM `news` WHERE `id` = '" . $_GET['article'] . "' ORDER BY `id` DESC", $conn));

					echo "<div class=\"article\">";
					echo "<p style=\"display: inline-block;\"><b class=\"article-title\" style=\"font-size: 1.5em;\">" . $query['title'] . "</b><br />by <a href=\"member.php?username=" . $query['author'] . "\">" . $query['author'] . "</a></p>";
					echo "<p>" . $query['content'] . "</p>";
					echo "<a href=\"index.php\">Return</a>";
					echo "</div><hr />";

					if (isset($_SESSION['username'])) {

						$query2 = mysql_query("SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "'");

							while ($row = mysql_fetch_assoc($query2)) {
								if ($_SESSION['authtoken'] == $row['authtoken']) {
									if ($query['author'] == $_SESSION['username'] || $row['admin']) {
										echo "<div>";
										echo "<a href=\"delete.php?article=" . $_GET['article'] . "\">Delete</a>";
										echo "</div><hr />";
									}
								}
							}
						}
				}

				mysql_close($conn) or die();

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