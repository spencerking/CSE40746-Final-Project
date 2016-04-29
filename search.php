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

	<title>NDBay - Search</title>

	<!-- Bootstrap core CSS -->
	<link href="styles/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<style>
		/* Move down content because we have a fixed navbar that is 50px tall */
		body {
			padding-top: 120px;
			padding-bottom: 20px;
		}
		footer {
			text-align: center;
		}
	</style>
	<link rel="stylesheet" href="styles/freelancer.css"/>
	<!-- Custom Fonts -->
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
							<li><a href="">Sign out</a></li>
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

		<?php

		$conn = oci_connect('guest', 'guest', 'localhost/XE');
		if (!$conn) {
			$e = oci_error();
			echo $e['message'];
			exit;
		}

		if (isset($_POST['search'])) {
			$searchText = $_POST['search'];
			$searchText = strtolower(str_replace("'", '', $searchText));
		}
		$query  = 'SELECT name, condition, description, price, end_time, item_id ';
		$query .= "FROM item ";
		$query .= "WHERE LOWER(name) LIKE '%".$searchText."%' AND item_id NOT IN (";
		$query .= "		SELECT item_id ";
		$query .= "		FROM favorite ";
		$query .= " 	WHERE (user_id=5 AND status=0)";
		$query .= ")";

		$stid = oci_parse($conn, $query);
		$r = oci_execute($stid);

		print '<div class="row">';
		while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
			print '<div class="col-md-4">';
			print '<h2><a href="item.php?iid='.$row['ITEM_ID'].'">'.$row['NAME'].'</a></h2>';
			print '<h4>$'.$row['PRICE'].'.00</h4>';
			print '<p>'.$row['DESCRIPTION'].'</p>';
			print '</div>';
		}
		print '</div>';

		oci_close($conn);

		?>
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
