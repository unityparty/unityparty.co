<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	if (null !== $_GET['username']) {
		$_SESSION['page'] = "member.php?username=" . $_GET['username'];
	} else {
		$_SESSION['page'] = "member.php";
	}

	include('includes/Mobile-Detect/Mobile_Detect.php');
	
	$client = new Mobile_Detect();
	if ($client->isMobile()) {
		if (!isset($_SESSION['view'])) {
			$_SESSION['view'] = 'mobile';
		}
	}

	include("template.php");

?>

		<div class="MAIN">

			<?php 

				if (null !== $_GET['username']) {

					$query = mysqli_query($conn, "SELECT * FROM `users`");

					$found = 0;
					while ($row = mysqli_fetch_assoc($query)) {
						if ($row['username'] == mysqli_real_escape_string($conn, $_GET['username'])) {
							$found = 1;

							if (isset($row['nickname'])) {
								echo "<p><b style=\"font-size: 1.5em;\">" . $row['nickname'] . "</b><br />";
								echo "@" . $row['username'] . "#" . $row['id'];
								echo "</p>";
							} else {
								echo "<p><b style=\"font-size: 1.5em;\">" . $row['username'] . "</b><br />";
								echo "@" . $row['username'] . "#" . $row['id'];
								echo "</p>";
							}

							echo "<p>" . bbParse($row['description']) . "</p>";

							if ($_SESSION['username'] == $row['username']) {
								echo "<br /><hr />";
								if ($_SESSION['authtoken'] == $row['authtoken']) {

									$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `users` WHERE `username` = '" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'"));
									echo "<form action=\"update.php\" method=\"POST\">";
									echo "<p>Nickname:</p>";
									if (is_null($user['nickname'])) {
										echo "<input type=\"text\" name=\"nickname\" value=\"" . $user['username'] . "\" /><br /><br />";
									} else {
										echo "<input type=\"text\" name=\"nickname\" value=\"" . $user['nickname'] . "\" /><br /><br />";
									}
									echo "<p>Description:</p>";
									echo "<textarea name=\"description\" rows=\"8\">" . $user['description'] . "</textarea><br /><br />";
									echo "<input type=\"submit\" value=\"Submit\" />";
									echo "</form><hr />";

									echo "<form action=\"delete.php\" method=\"POST\">";
									echo "<input type=\"text\" name=\"method\" value=\"user\" style=\"display: none;\" />";
									echo "<input type=\"password\" placeholder=\"Password\" /><br /><br />";
									echo "<p>Note: this feature is not yet implemented.</p>";
									echo "<input type=\"submit\" value=\"Delete Account\" />";
									echo "</form>";
								} else {
									echo "<p><b>Invalid authentication token.</b></p>";
								}
							}
						}
					}

					if (!$found) {
						echo "User " . mysqli_real_escape_string($conn, $_GET['username']) . " not found.";
					}

				} else {
					echo "Still working on it (you can view specific profiles, though).";
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