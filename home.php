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

	<title>NDBay - Home</title>

	<!-- Bootstrap core CSS -->
	<link href="styles/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<style>
		/* Move down content because we have a fixed navbar that is 50px tall */
		body {
			padding-top: 50px;
			padding-bottom: 20px;
		}
		footer {
			text-align: center;
		}
	</style>
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
				<a class="navbar-brand" href="home.php">NDBay</a>
				<li class="navbar-brand">
					<?php
						$conn = oci_connect("guest", "guest", "xe")
							or die("Couldn't connect");
						$query1 = "SELECT email email FROM domer WHERE user_id='".$_SESSION['user_id']."'";
						$stmt1 = oci_parse($conn, $query1);
						oci_define_by_name($stmt1, "EMAIL", $email);
						oci_execute($stmt1);
						oci_fetch($stmt1);
						print "$email"
					?>
				</li>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="sell.php">Sell</a></li>
					<li><a href="messages.php">Messages</a></li>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" roles="button" aria-haspopup="true" aria-expanded="false">Settings<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="account.php">Account</a></li>
							<li><a href="">Sign out</a></li>
						</ul>
					</li>
				</ul>
				<form class="navbar-form navbar-right" action="search_backend.php" role="search" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="search" placeholder="Search">
					</div>
					<button type="submit" class="btn btn-default">Go</button>
				</form>
			</div>
		</div>
	</div>
</nav>

<div class="container">
	<h2>Your Listed Items:</h2>
	<div class="row">
		<div class="col-md-4">
			<h2><a>Heading</a></h2>
			<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		</div>
		<div class="col-md-4">
			<h2><a>Heading</a></h2>
			<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		</div>
		<div class="col-md-4">
			<h2><a>Heading</a></h2>
			<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
		</div>
	</div>

	<h2>Your Favorites:</h2>
	<div class="row">
		<div class="col-md-4">
			<h2><a>Heading</a></h2>
			<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		</div>
		<div class="col-md-4">
			<h2><a>Heading</a></h2>
			<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
		</div>
		<div class="col-md-4">
			<h2><a>Heading</a></h2>
			<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
		</div>
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