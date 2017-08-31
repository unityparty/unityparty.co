<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "index.php";

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

		<title>Unity Party | Join</title>
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
				<td><a href="join.php" class="selected">Join</a></td>
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

		<div class="MAIN" style="text-align: justify;">

			<p>A Full Member of the Unity Party is someone who accepts the platform of the Party and makes a formal committment to support its activities, either financially or in time and effort. Individuals may also join as non-voting Associate Members if they wish to explore the opportunities the Party has to offer before making a formal committment to our aims and projects.</p>
 
			<p>The Unity Party welcomes members of all races, genders, sexual orientations, nationalities, and social backgrounds.</p>
 
			<p>The Unity Party is a democratic, egalitarian community committed to strong organisational principles. Every one of our goals and strategies stand on the decisions taken by all full Party members during our bi-annual General Meetings, and elected officials are immediately recallable. In this way, full membership guarantees a permanent voice in all Party affairs.</p>
 
			<p>More about our aims, principles and organisational structure can be found in our official Platform and our Party By-laws.</p>
 
			<p>To become an Associate Member, simply become an active participant in one of our communities on Reddit, Discord or IRC and see for yourself what our Party is about.</p>

			<p>Those wishing to take the step towards full membership may apply by filling out this short form, in which you should feel free to articulate your political beliefs and your aims in joining the Party in your own words, at whatever length you like.</p>
 
			<p>Membership is free, but we ask that Party members make whatever donations they can in order to sustain our efforts.</p>

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