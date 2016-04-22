<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header('Location: signin.html');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">

	<title>NDBay - Account</title>

	<!-- Bootstrap core CSS -->
	<link href="styles/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="styles/account.css" rel="stylesheet">
	<style>
		/* Move down content because we have a fixed navbar that is 50px tall */
		body {
			padding-top: 120px;
			padding-bottom: 20px;
		}
		footer {
			text-align: center;
		}
		.container h2 {
			text-align: center;
		}
		.container p {
			text-align: center;
		}
	</style>
	<link rel="stylesheet" href="styles/freelancer.css"/>
	<!-- Custom Fonts -->
	<link href="styles/bootstrap.min.css" rel="stylesheet">
	<link href="styles/font-awesome.min.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="home.php"><img style="position:relative; top:-12.5px;" height="50px" width="auto" src="images/NDBayLogo.png"/></a>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<form class="navbar-form" action="search.php" role="search" method="post">
							<div class="form-group">
								<input type="text" class="form-control" name="search" placeholder="Search Items">
							</div>
							<button type="submit" class="btn btn-default">Go</button>
						</form>
					</li>
					<li><a href="sell.php">Sell</a></li>
					<li><a href="browse.php">Browse</a></li>
					<li><a href="favorites.php">Favorites</a></li>
					<li><a href="messages.php">Messages</a></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" roles="button" aria-haspopup="true" aria-expanded="false">
							<?php
							$conn = oci_connect("guest", "guest", "xe")
							or die("Couldn't connect");
							$query1 = "SELECT email email FROM domer WHERE user_id='".$_SESSION['user_id']."'";
							$stmt1 = oci_parse($conn, $query1);
							oci_define_by_name($stmt1, "EMAIL", $email);
							oci_execute($stmt1);
							oci_fetch($stmt1);
							print "$email ";
							oci_close($conn);
							?>
							<span class="caret"></span>
						</a>
						<ul class="dropdown-menu">
							<li><a href="account.php">Account</a></li>
							<li><a href="signout_backend.php">Sign out</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="container">
		<?php
		// Import the function from alerts.php
		include 'alerts.php';
		use NDBay_Alerts as Alerts;

		// If there is an alert message passed in, call print_alerts
		if (isset($_GET['c']))
		{
			Alerts\print_alert($_GET['c']);
		}
		?>
		<h2>Transaction History</h2>
		<hr/>
		<div id="history">
			<?php
			$conn = oci_connect("guest", "guest", "xe")
			or die("Couldn't connect");
			$query = "SELECT I.name n, I.price p, T.transaction_date d FROM item I, transaction T WHERE T.buyer_id='".$_SESSION['user_id']."'";
			$stmt = oci_parse($conn, $query);
			oci_define_by_name($stmt, "N", $n);
			oci_define_by_name($stmt, "P", $p);
			oci_define_by_name($stmt, "D", $d);
			oci_execute($stmt);
			print "<table>";
			while (oci_fetch($stmt)) {
				print "<tr><td>$n</td><td>$p</td><td>$d</td></tr>";
			}
			print "</table>";
			if (oci_num_rows($stmt) == 0) {
				print "<p>No transactions found :(</p>";
			}
			oci_close($conn);
			?>
		</div>
		<h2>Change Password</h2>
		<hr/>
		<form class="form-signin" action="change_pass_backend.php" method="post">
			<label for="oldPass" class="sr-only">Old Password</label>
			<input type="password" id="oldPassword" name="oldPass" class="form-control" placeholder="Old Password" autofocus>
			<label for="inputPassword" class="sr-only">Password</label>
			<input type="password" id="inputPassword" name="password" class="form-control" placeholder="New Password">
			<label for="inputConfirmPassword" class="sr-only">Confirm password</label>
			<input type="password" id="inputConfirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm Password">
			<div class="error"><ul></ul></div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
		</form>
	</div>

	<hr>

	<footer>
		<p>Made with &lt;3 at Notre Dame, by Thomas, Spencer, and David.</p>
	</footer>
</div>


  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="js/jquery-2.2.2.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>