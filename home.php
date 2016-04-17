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
				<a class="navbar-brand">
					<small>
						<?php
							$conn = oci_connect("guest", "guest", "xe")
								or die("Couldn't connect");
							$query1 = "SELECT email email FROM domer WHERE user_id='".$_SESSION['user_id']."'";
							$stmt1 = oci_parse($conn, $query1);
							oci_define_by_name($stmt1, "EMAIL", $email);
							oci_execute($stmt1);
							oci_fetch($stmt1);
							print "$email";
							oci_close($conn);
						?>
					</small>
				</a>
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
		<?php
			// Grab all of the items being sold by this user.
			$conn = oci_connect("guest", "guest", "xe")
				or die("Couldn't connect");

			$query2  = "SELECT i.item_id iid, i.description des, i.name name ";
			$query2 .= "FROM item i ";
			$query2 .= "WHERE i.seller_id=". $_SESSION['user_id'];

			$stmt2 = oci_parse($conn, $query2);

			oci_execute($stmt2);
			
			$row = oci_fetch_assoc($stmt2);
			if ($row != false)
			{
				while ($row != false)
				{			
					// Write query on item_photo for filepath
					$query3 = "SELECT ip.filename fn, ip.description de ";
					$query3 .= "FROM item_photo ip ";
					$query3 .= "WHERE ip.item_id=".$row['IID'];

					$stmt3 = oci_parse($conn, $query3);
					oci_define_by_name($stmt3, "FN", $fn);
					oci_define_by_name($stmt3, "DE", $de);

					oci_execute($stmt3);
					oci_fetch($stmt3);

					print "<div class=\"col-md-4\">\n";
					print "\t<img src=\"./server_images/".$fn."\" class=\"img-thumbnail\"\>";
					print "\t<h2><a href=\"item.php?iid=".$row['IID']."\">".$row['NAME']."</a></h2>\n";
					print "\t<p>".$row['DES']."</p>\n";
					print "</div>\n";

					$row = oci_fetch_assoc($stmt2);
				}	
			}
			else
			{
				// There are no items for this user
				print "<div class=\"col-md-4\">\n";
				print "\t<h2><a>No Items Listed</a></h2>\n";
				print "</div>\n";
			}

			oci_close($conn);
		?>
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