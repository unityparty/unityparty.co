<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "about.php";

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

		<title>Unity Party | About</title>
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
				<td><a href="about.php" class="selected">About</a></td>
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

		<div class="MAIN" style="text-align: justify;">

			<p>The Unity Party is an international association of the political left, dedicated to fostering unity and concerted action with the aim of rebuilding working-class consciousness in the 21st century. We draw upon leftists of all stripes in the hope that what unites us - a committment to equality, justice, freedom, and the Planet we all live on - is stronger than what divides us.</p>
 
			<p>We stand opposed to capitalism and deathly opposed to capitalism's truest manifestation: the xenophobic nationalism of the extreme right, with its lynching of minorities, brutalisation of workers and repression of left-wing dissent. For that, we are sworn enemies of all forms of bigotry, be they based on race, class, gender or the lack thereof, sexual orientation, nationality, religion, age, or ability.</p>
 
			<p>We believe that the most important task facing leftists in this young century is the task of restoring to its rightful place the idea of the working class as a primary motivator of history. To accomplish this, we define the working class as all those, regardless of their personal traits, who live primarily by the sale of their labour to others, rather than primarily by the ownership of property or capital. In this sense, the vast majority of human beings are workers, and that is the commonality that binds us and will carry us into the future.</p>
 
			<p>Our activities are many. Our projects are simple: create and deploy narratives that support the notion of a resurgent, re-animated politically militant working class. This means creating written, audio, and visual media; distribution of literature and brochures; organisation of film clubs, reading groups and study societies; sponsorship of educational programs in schools and communities; vigorous information warfare online; and much more.</p>
			
			<p>We ask of all those who have a stake in the coming future - a future characterised, in the short term, by deepening inequality, rising oceans, warming weather, and a newly powerful fascist enemy - to join us and help, in whatever way they can, to build the only thing capable of bringing back the human species from the precipice on which it is dancing: a mass movement of the working class, which is humanity itself, armed with the knowledge of its destiny as inheritors of the Earth.</p>

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