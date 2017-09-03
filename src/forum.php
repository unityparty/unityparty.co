<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "forum.php";

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
			<p>Coming soon.</p><hr />

			<?php

				if (isset($_GET['forum'])) {

					echo "<div class=\"category\">";

					$query0 = mysqli_query($conn, "SELECT * FROM `forums`");
					while ($row0 = mysqli_fetch_assoc($query0)) {
						if ($row0['id'] == $_GET['forum']) {
							if (!is_null($row0['parent'])) {
								echo "<p><b style=\"font-size: 1.5em\">" . $row0['name'] . "</b><br />" . $row0['description'] . "</p>";

								$query1 = mysqli_query($conn, "SELECT * FROM `threads` ORDER BY `id` DESC");
								while ($row1 = mysqli_fetch_assoc($query1)) {
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

					$query = mysqli_query($conn, "SELECT * FROM `threads`");
					
					echo "<div class=\"category\">";

					while ($row = mysqli_fetch_assoc($query)) {
						if ($row['id'] == $_GET['thread']) {
							echo "<p><b>" . $row['title'] . "</b> by <a href=\"member.php?username=" . $row['author'] . "\">" . $row['author'] . "</a><br />" . $row['content'] . "</p>";
						}
					}

					echo "</div>";

					$query = mysqli_query($conn, "SELECT * FROM `threads`");
					while ($row = mysqli_fetch_assoc($query)) {
						if ($row['parent'] == $_GET['thread']) {
							echo "<div class=\"category\">";
							echo "<p>" . $row['content'] . "</p><p>by <a href=\"member.php?username=" . $row['author'] . "\">" . $row['author'] . "</a></p>";
							echo "</div>";
						}
					}

				} else {

					$query = mysqli_query($conn, "SELECT * FROM `forums`");

					while ($row0 = mysqli_fetch_assoc($query)) {
						if (is_null($row0['parent'])) {
							echo "<div class=\"category\">";
							echo "<p><b style=\"font-size: 1.5em;\">" . $row0['name'] . "</b><br />" . $row0['description'] . "</p>";

							while ($row1 = mysqli_fetch_assoc($query)) {
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