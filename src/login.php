<?php 
	session_start();
	$_SESSION['previous'] = $_SESSION['page'];
	$_SESSION['page'] = "login.php";

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

				if (isset($_POST['username'])) {

					$username = $_POST['username'];
					$password = $_POST['password'];

					$query = mysqli_query($conn, "SELECT * FROM `users`");
					$found = 0;
					while ($row = mysqli_fetch_assoc($query)) {
						if ($username  == $row['username']) {

							$found = 1;
							$hash = $row['password'];
							
						}
					}

					if ($found) {

						if (password_verify($password, $hash)) {

							$authtoken = rand(0, 999999999);

							$query = mysqli_query($conn, "UPDATE `users` SET `authtoken` = " . mysqli_real_escape_string($conn, $authtoken) . " WHERE `username` = '" . mysqli_real_escape_string($conn, $username) . "'");

							$_SESSION['authtoken'] = $authtoken;
							$_SESSION['username'] = $username;

							echo "<hr />Successful";

							echo "<meta http-equiv=\"refresh\" content=\"0; url=index.php\" />";
						} else {
							echo "Incorrect password.";
						}

					} else {
						echo "User doesn't exist.";
					}

				} else {

					echo "<form action=\"login.php\" method=\"POST\">";
					echo "<input type=\"text\" name=\"username\" placeholder=\"Username\" /><br />";
					echo "<input type=\"password\" name=\"password\" placeholder=\"Password\" /><br />";
					echo "<input type=\"submit\" value=\"Log in\" />";
					echo "</form>";

				}

				//password_verify('test password', $hash)

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