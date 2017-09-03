<?php 
	session_start();
	if (isset($_SESSION['page'])) {
		$_SESSION['previous'] = $_SESSION['page'];
	}
	$_SESSION['page'] = "index.php";

	include ('includes/Mobile-Detect/Mobile_Detect.php');
	
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

				if (!isset($_GET['article'])) {

					if (isset($_SESSION['username'])) {
						$query = mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '" . $_SESSION['username'] . "'");
						while ($row = mysqli_fetch_assoc($query)) {
							if ($row['writer'] == '1') {
							echo "<a href=\"postarticle.php\">Post article</a>";
							}
						}
					}

					$query = mysqli_query($conn, "SELECT * FROM `news` ORDER BY `id` DESC");

					while ($row = mysqli_fetch_assoc($query)) {
						echo "<div class=\"article\">";
						echo "<p><b class=\"article-title\">" . $row['title'] . "</b> by <a href=\"member.php?username=" . $row['author'] . "\">" . $row['author'] . "</a></p>";
						echo "<p style=\"text-align: justify\">" . $row['brief'] . "</p>";
						echo "<p>Click <a href=\"?article=" . $row['id'] . "\">here</a> to read more.</p>";
						echo "</div><hr />";

					}

				} else {

					$query = mysqli_query($conn, "SELECT * FROM `news` WHERE `id` = '" . $_GET['article'] . "' ORDER BY `id` DESC");
					$query = mysqli_fetch_assoc($query);

					echo "<div class=\"article\">";
					echo "<p style=\"display: inline-block;\"><b class=\"article-title\" style=\"font-size: 1.5em;\">" . $query['title'] . "</b><br />";
					echo "by <a href=\"member.php?username=" . $query['author'] . "\">" . $query['author'] . "</a> at " . substr($query['date'], 11) . " on " . substr($query['date'], 0, 11) . "</p>";
					echo "<p style=\"text-align: justify\">" . $query['content'] . "</p>";
					echo "<a href=\"index.php\">Return</a>";
					echo "</div><hr />";

					if (isset($_SESSION['username'])) {

						$query2 = mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'");

							while ($row = mysqli_fetch_assoc($query2)) {
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

				mysqli_close($conn) or die();

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