<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "volunteer.php";

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

		<title>Unity Party | Volunteer</title>
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
				<td><a href="volunteer.php" class="selected">Volunteer</a></td>
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

		<div class="MAIN" style="text-align: justify;">

			<p>Full Unity Party members can volunteer for any of the exciting projects being undertaken by our five Working Groups. Working Group activities include creating journalistic content, imagery, podcasts, video, infographics, and other media; recruitment efforts and distribution of literature and images; organisation of fundraisers, educational events, and group social activities; programming, maintenance of Party databases and platforms, and other coding projects; and much more. Find out more about each Working Group and their role within the Party structure in the By-laws.</p>

			<p>One of the working groups is the Web Admin Working Group, who create and maintain this website. To help, feel free to look at the github for this at <a href="https://github.com/unityparty/unityparty.co" target="_BLANK">https://github.com/unityparty/unityparty.co</a>.</p>

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