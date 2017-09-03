<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "signup.php";

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

				if (!isset($_SESSION['username'])) {

					if (isset($_POST['username'])) {

						$username = $_POST['username'];
						$password = password_hash($_POST['password'], PASSWORD_DEFAULT, ['cost' => 12]);

						$query = mysqli_query($conn, "SELECT * FROM `users`");
						$found = 0;
						while ($row = mysqli_fetch_assoc($query)) {

							if ($row['username'] == $username) {
								$found = 1;
							}

						}

						if (!$found) {

							$authtoken = rand(0, 999999999);
							
							$query = mysqli_query($conn, "INSERT INTO `users` (`id`, `username`, `password`, `authtoken`, `nickname`, `description`, `admin`, `writer`) VALUES (NULL, '" . mysqli_real_escape_string($conn, $username) . "', '" . mysqli_real_escape_string($conn, $password) . "', '" . mysqli_real_escape_string($conn, $authtoken) . "', NULL, NULL, '0', '0')", $conn);
							$_SESSION['username'] = $username;
							$_SESSION['authtoken'] = $authtoken;
							echo "Successful";
							echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" />";

						} else {
							echo "Username already in use.";
						}

					} else {
						echo "<form action=\"signup.php\" method=\"POST\">";
						echo "<input type=\"text\" name=\"username\" placeholder=\"Username\" /><br />";
						echo "<input type=\"password\" name=\"password\" placeholder=\"Password\" /><br />";
						echo "<input type=\"submit\" value=\"Sign up\" />";
						echo "</form>";
					}
				} else {
					echo "Already signed in";
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