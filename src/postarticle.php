<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "postarticle.php";

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

		<title>Unity Party | Post Article</title>
		<?php
			if ($_SESSION['view'] == 'mobile') {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/mobilemain.css\" />";
			} else {
				echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/main.css\" />";
			}
		?>
		<link rel="stylesheet" type="text/css" href="assets/css/news.css" />

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

				if (!isset($_POST['title'])) {

					if (isset($_SESSION['username'])) {

						$username = $_SESSION['username'];
						$authtoken = $_SESSION['authtoken'];

						$conn = mysql_connect($config['dbaddr'], $config['dbuser'], $config['dbpass']);
						mysql_select_db($config['dbname'], $conn);

						$query = mysql_query("SELECT * FROM `users` WHERE `username` = '" . $username . "'");

						$auth = 0;
						while ($row = mysql_fetch_assoc($query)) {

							if ($row['authtoken'] == $authtoken) {
								
								if ($row['writer'] == 1) {
									$auth = 1;
								}

							} else {
								echo "Authentication failed.<br />";
							}

						}

						if ($auth) {
							
							echo "<form action=\"postarticle.php\" method=\"POST\">";
							echo "<input type=\"text\" name=\"title\" placeholder=\"Title\" /><br />";
							echo "<textarea name=\"brief\" placeholder=\"Brief\"></textarea><br />";
							echo "<textarea name=\"content\" placeholder=\"Content (full)\"></textarea><br />";
							echo "<input type=\"submit\" value=\"Submit\" /><br />";
							echo "</form>";

						} else {
							echo "You are not allowed to write articles";
						}

						mysql_close($conn);
					} else {
						echo "You are not logged in.";
					}
				} else {
					$conn = mysql_connect($config['dbaddr'], $config['dbuser'], $config['dbpass']);
					mysql_select_db($config['dbname'], $conn);

					$title = $_POST['title'];
					$brief = $_POST['brief'];
					$content = $_POST['content'];
					$author = $_SESSION['username'];

					if (strpos($content, "<script") !== FALSE) {
						echo "<p>Scripts not allowed.</p>";
					} else {

						$query = mysql_query("INSERT INTO `news` (`id`, `title`, `content`, `brief`, `author`) VALUES (NULL , '" . $title . "', '" . $content . "', '" . $brief . "', '" . $author . "')");

						mysql_close($conn);
						echo "Success!";
					}
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