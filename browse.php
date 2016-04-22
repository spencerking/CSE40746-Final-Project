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

	<title>NDBay - Browse All</title>

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
	<link rel="stylesheet" type="text/css" href="styles/listing.css"/>
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
						<form class="navbar-form" action="search_backend.php" role="search" method="post">
							<div class="form-group">
								<input type="text" class="form-control" name="search" placeholder="Search Items">
							</div>
							<button type="submit" class="btn btn-default">Go</button>
						</form>
					</li>
					<li><a href="sell.php">Sell</a></li>
					<li class="active"><a href="browse.php">Browse</a></li>
					<li><a href="favorites_list.php">Favorites</a></li>
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
		$code = $_GET['c'];
		switch ($code) 
		{
			case 0:
				break;
			case 1:
				print "
					<div class=\"alert alert-danger\">
					<p>
						<strong>ERROR!!! Your item listing was not uploaded!</strong><br/>
						Please make sure you filled out all of the fields and that the image is smaller than 8 MB.
					</p>
					</div>
				";
				break;
			case 2:
				print "
					<div class=\"alert alert-success\">
					<p>
						<strong>Your image was successfully uploaded!</strong>
					</p>
					</div>
				";
				break;
			case 3:
				print "
					<div class=\"alert alert-info\">
					<p>
						<strong>This item will now be in your favorites list!</strong><br/>
						Favorite items can viewed on the favorites page and up to eight of them will be previewed on the home page.
					</p>
					</div>
				";
				break;
			case 4:
				print "
					<div class=\"alert alert-warning\">
					<p>
						<strong>This item will no longer show up while browsing!</strong><br/>
						Disliked items can be viewed under the favorited items on the NDBay Favorites page.
					</p>
					</div>
				";
				break;
			case 5:
				print "
					<div class=\"alert alert-success\">
					<p>
						<strong>Your item listing was successfully posted!</strong>
					<\p>
					</div>
				";
				break;
			default:
				break;
		}
		?>
		<h2 class="text-center">All Items</h2>
		<hr/>
		<div class="row">
			<?php
			// Grab all of the items favorited by this user.
			$conn = oci_connect("guest", "guest", "xe")
			or die("Couldn't connect");

			$query2  = "SELECT i.item_id iid, i.description des, i.name name ";
			$query2 .= "FROM item i, favorite f ";
			$query2 .= "WHERE (f.user_id!=". $_SESSION['user_id'] ." OR f.status!=0) ";
			$query2 .= "AND f.item_id=i.item_id AND i.seller_id!=". $_SESSION['user_id'];

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

					print "<div id=\"listing\" class=\"col-md-4\">\n";
					print "\t<a href=\"item.php?iid=".$row['IID']."\"><img id=\"img_listing\" src=\"./server_images/".$fn."\" class=\"img-thumbnail img-responsive\"\></a>\n";
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