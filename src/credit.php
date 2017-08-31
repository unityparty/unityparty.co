<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "credit.php";

	include('config.php');
	include('includes/Mobile-Detect/Mobile_Detect.php');

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

		<title>Unity Party | Credit</title>
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
					echo "<a href=\"member.php\">Members</a>";
					echo "<a href=\"signout.php\">Sign out</a>";
				}
			?>
		</div>

		<div class="MAIN">

			<p>
				<b>Mobile-Detect</b><br />
				<a href="http://mobiledetect.net/" target="_BLANK">Website</a>
				<a href="https://github.com/serbanghita/Mobile-Detect" target="_BLANK">Github</a>
			</p>

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