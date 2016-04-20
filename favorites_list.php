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

	<title>NDBay - Favorites List</title>

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
				<a class="navbar-brand" href="home.php"><img style="position:relative; top:-12.5px;" height="50px" width="auto" src="images/NDBayLogo.png"/></a>
				<form class="navbar-form navbar-right" action="search_backend.php" role="search" method="post">
					<div class="form-group">
						<input type="text" class="form-control" name="search" placeholder="Search Items">
					</div>
					<button type="submit" class="btn btn-default">Go</button>
				</form>
			</div>
			<div id="navbar" class="navbar-collapse collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="sell.php">Sell</a></li>
					<li class="active"><a href="favorites_list.php">Favorites</a></li>
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
						<span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="account.php">Account</a></li>
							<li><a href="">Sign out</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>
</nav>


<div class="container">
	<h2 class="text-center"><strong>Liked and Disliked Items</strong></h2>
	<hr/>
	<h2 class="text-left">Favorites:</h2>
	<div class="row">
		<?php
			// Grab all of the items favorited by this user.
			$conn = oci_connect("guest", "guest", "xe")
				or die("Couldn't connect");

			$query2  = "SELECT i.item_id iid, i.description des, i.name name ";
			$query2 .= "FROM item i, favorite f ";
			$query2 .= "WHERE f.user_id=". $_SESSION['user_id'] ."AND f.status=1 AND f.item_id=i.item_id";

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

					if ($fn == NULL)
					{
						$fn = "no-image.jpg";
					}

					print "<div class=\"col-md-4\">\n";
					print "\t<a href=\"item.php?iid=".$row['IID']."\"><img src=\"./server_images/".$fn."\" class=\"img-thumbnail img-responsive\"\></a>\n";
					print "\t<h2><a href=\"item.php?iid=".$row['IID']."\">".$row['NAME']."</a></h2>\n";
					print "\t<p>".$row['DES']."</p>\n";
					print "</div>\n";

					$fn = NULL;
					$row = oci_fetch_assoc($stmt2);
				}	
			}
			else
			{
				// There are no items for this user
				print "<div class=\"col-md-4\">\n";
				print "\t<h2><a>No Favorited Items</a></h2>\n";
				print "</div>\n";
			}

			oci_close($conn);
		?>
	</div>

	<h2 class="text-left">Disliked Items:</h2>
	<div class="row">
		<?php
			// Grab all of the items disliked by this user.
			$conn = oci_connect("guest", "guest", "xe")
				or die("Couldn't connect");

			$query4  = "SELECT i.item_id iid, i.description des, i.name name ";
			$query4 .= "FROM item i, favorite f ";
			$query4 .= "WHERE f.user_id=". $_SESSION['user_id'] ."AND f.status=0 AND f.item_id=i.item_id";

			$stmt4 = oci_parse($conn, $query4);

			oci_execute($stmt4);
			
			$row = oci_fetch_assoc($stmt4);
			if ($row != false)
			{
				while ($row != false)
				{			
					// Write query on item_photo for filepath
					$query5 = "SELECT ip.filename fn, ip.description de ";
					$query5 .= "FROM item_photo ip ";
					$query5 .= "WHERE ip.item_id=".$row['IID'];

					$stmt5 = oci_parse($conn, $query5);
					oci_define_by_name($stmt5, "FN", $fn);
					oci_define_by_name($stmt5, "DE", $de);

					oci_execute($stmt5);
					oci_fetch($stmt5);

					if ($fn == NULL)
					{
						$fn = "no-image.jpg";
					}

					print "<div class=\"col-md-4\">\n";
					print "\t<a href=\"item.php?iid=".$row['IID']."\"><img src=\"./server_images/".$fn."\" class=\"img-thumbnail img-responsive\"\></a>\n";
					print "\t<h2><a href=\"item.php?iid=".$row['IID']."\">".$row['NAME']."</a></h2>\n";
					print "\t<p>".$row['DES']."</p>\n";
					print "</div>\n";

					$fn = NULL;
					$row = oci_fetch_assoc($stmt4);
				}	
			}
			else
			{
				// There are no items for this user
				print "<div class=\"col-md-4\">\n";
				print "\t<h2><a>No Disliked Items</a></h2>\n";
				print "</div>\n";
			}

			oci_close($conn);
		?>
	</div>

	<hr/>
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