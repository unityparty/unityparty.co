<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "postarticle.php";

	include('includes/Mobile-Detect/Mobile_Detect.php');

	$client = new Mobile_Detect();
	if ($client->isMobile()) {
		if (!isset($_SESSION['view'])) {
			$_SESSION['view'] = 'mobile';
		}
	}

	include('template.php');
?>

		<div class="MAIN">

			<?php

				if (!isset($_POST['title'])) {

					if (isset($_SESSION['username'])) {

						$username = $_SESSION['username'];
						$authtoken = $_SESSION['authtoken'];

						$query = mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '" . mysqli_real_escape_string($conn, $username) . "'");

						$auth = 0;
						while ($row = mysqli_fetch_assoc($query)) {

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

					} else {
						echo "You are not logged in.";
					}
				} else {

					$title = $_POST['title'];
					$brief = $_POST['brief'];
					$content = $_POST['content'];
					$author = $_SESSION['username'];

					if (strpos($content, "<script") !== FALSE) {
						echo "<p>Scripts not allowed.</p>";
					} else {

						$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'"));

						if ($user['authtoken'] == $_SESSION['authtoken']) {
							if ($user['writer']) {
								$query = mysqli_query($conn, "INSERT INTO `news` (`id`, `title`, `content`, `brief`, `author`) VALUES (NULL , '" . mysqli_real_escape_string($conn, $title) . "', '" . mysqli_real_escape_string($conn, $content) . "', '" . mysqli_real_escape_string($conn, $brief) . "', '" . mysqli_real_escape_string($conn, $author) . "')");

								echo "Success!";
							} else {
								echo "Failure.";
							}
						} else {
							echo "Failure.";
						}
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