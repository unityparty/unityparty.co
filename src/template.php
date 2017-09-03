<?php 

	// GET DATA

	include('config.php');

	$conn = mysqli_connect($config['dbaddr'], $config['dbuser'], $config['dbpass'], $config['dbname']);

	//// Page specific
	if ($_SESSION['page'] == "index.php") {
		$pageTitle = "News";
		$pageCSS = "news.css";
	} elseif ($_SESSION['page'] == "postarticle.php") {
		$pageTitle = "Post Article";
	} elseif ($_SESSION['page'] == "signup.php") {
		$pageTitle = "Sign Up";
	} elseif ($_SESSION['page'] == "login.php") {
		$pageTitle = "Log In";
	} elseif (strpos($_SESSION['page'], "forum.php") !== FALSE) {
		$pageTitle = "Forum";
		$pageCSS = "forum.css";
	} elseif (strpos($_SESSION['page'], "member.php") !== FALSE) {
		$pageTitle = "Members - " . substr($_SESSION['page'], 20);
	} else {
		$pageTitle = strtoupper(substr($_SESSION['page'], 0, 1)) . substr($_SESSION['page'], 1, -4);
	}

	// DISPLAY
	/// Head
	echo "<!DOCTYPE html>";
	echo "<html>";

	echo "<head>";

	echo "<title>Unity Party | " . $pageTitle . "</title>";

	if ($_SESSION['view'] == 'mobile') {
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/mobilemain.css\" />";
	} else {
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/main.css\" />";
	}
	if ($pageCSS !== null) {
		echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"assets/css/" . $pageCSS . "\" />";
	}

	echo "<link rel=\"shortcut icon\" href=\"/assets/images/favicon.ico\">";

	echo "</head>";


	//// Body
	echo "<body>";

	////// Notice
	if (!is_null($config['notice'])) {
		echo "<div class=\"NOTICE\">";
		echo "<b>" . $config['notice'] . "</b>";
		echo "</div>";
	}

	////// Banner
	echo "<div class=\"BANNER\">";
	echo "<a href=\"index.php\"><img src=\"assets/images/banner.png\" width=100% /></a>";
	echo "</div>";

	////// Main menu
	echo "<div class=\"MENU\">";
	echo "<table><tr>";
	if ($pageTitle == "News") {
		echo "<td><a href=\"index.php\" class=\"selected\">News</a></td>";
	} else {
		echo "<td><a href=\"index.php\">News</a></td>";
	}
	echo "<td><a href=\"about.php\">About</a></td>";
	echo "<td><a href=\"join.php\">Join</a></td>";
	echo "<td><a href=\"donate.php\">Donate</a></td>";
	echo "<td><a href=\"volunteer.php\">Volunteer</a></td>";
	echo "</tr></table>";
	echo "</div>";

	////// User menu
	echo "<div class=\"USERMENU\">";
	if (!isset($_SESSION['username'])) {
		if ($pageTitle == "Sign Up") {
			echo "<a href=\"signup.php\" class=\"uselected\">Sign up</a>";
		} else {
			echo "<a href=\"signup.php\">Sign up</a>";
		}

		if ($pageTitle == "Log In") {
			echo "<a href=\"login.php\" class=\"uselected\">Log in</a>";
		} else {
			echo "<a href=\"login.php\">Log in</a>";
		}
	} else {
		echo "<a href=\"member.php?username=" . $_SESSION['username'] . "\">" . $_SESSION['username'] . "</a>";

		if ($pageTitle == "Forum") {
			echo "<a href=\"forum.php\" class=\"uselected\">Forums</a>";
		} else {
			echo "<a href=\"forum.php\">Forums</a>";
		}

		if (substr($pageTitle, 0, 7) == "Members") {
			echo "<a href=\"member.php\" class=\"uselected\">Members</a>";
		} else {
			echo "<a href=\"member.php\">Members</a>";
		}

		echo "<a href=\"signout.php\">Sign out</a>";
	}
	echo "</div>";

?>