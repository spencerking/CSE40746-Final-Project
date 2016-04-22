<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
	header('Location: signin.html');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<link rel="icon" href=""/>

	<title>NDBay - Item</title>

	<link href="styles/bootstrap.min.css" rel="stylesheet"/>
	<link rel="stylesheet" href="styles/jquery.mThumbnailScroller.css"/>
	<script src="js/jquery-2.2.2.min.js"></script>
	<script src="js/jquery.mThumbnailScroller.min.js"></script>

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

		span.shams, span.shams span {
			display: block;
			background: url(images/shams.png) 0 -16px repeat-x;
			width: 80px;
			height: 16px;
		}

		span.shams span {
			background-position: 0 0;
		}

		#my-thumbs-list {
			overflow: auto;
			position: relative;
			padding: 10px;
			background-color: #333;
			margin: 20px;
			width: 100%;
			height: auto;
			float: left;
		}
		#my-thumbs-list li {
			margin: 4px;
			overflow: hidden;
		}
		#my-thumbs-list li a {
			display: inline-block;
			border: 7px solid rgba(255,255,255,.1);
		}

		#scrimg {
			height:250px;
		}
	</style>
	<link rel="stylesheet" href="styles/freelancer.css"/>
	<!-- Custom Fonts -->
	<link href="styles/font-awesome.min.css" rel="stylesheet">
	<link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
	<link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">


	<script type="text/javascript">
		$(document).ready(function() {       
			$('span.shams').shams();
		});

		$.fn.shams = function() {
			return $(this).each(function() {
				var val = parseFloat($(this).html());
				var size = Math.max(0, (Math.min(5, val))) * 16;
		// Create stars holder
		var $span = $('<span />').width(size);
		// Replace the numerical value with stars
		$(this).html($span);
	});
		};
	</script>

	<?php

	$iid = $_GET['iid'];

	$vendor_is_user = false;

	$conn = oci_connect("guest", "guest", "xe")
	or die("Couldn't connect");

	$query1 = "SELECT i.seller_id s, i.name n, i.condition c, i.description d, i.price p, i.end_time e ";
	$query1 .= "FROM item i ";
	$query1 .= "WHERE i.item_id=$iid";

	$stmt1 = oci_parse($conn, $query1);
	oci_define_by_name($stmt1, "S", $s);
	oci_define_by_name($stmt1, "N", $n);
	oci_define_by_name($stmt1, "C", $c);
	oci_define_by_name($stmt1, "D", $d);
	oci_define_by_name($stmt1, "P", $p);
	oci_define_by_name($stmt1, "E", $e);

	oci_execute($stmt1);
	oci_fetch($stmt1);

  // Write query on item_photo for filepath
	$query3 = "SELECT ip.filename fn, ip.description de ";
	$query3 .= "FROM item_photo ip ";
	$query3 .= "WHERE ip.item_id=$iid";

	$stmt3 = oci_parse($conn, $query3);
	oci_define_by_name($stmt3, "FN", $fn);
	oci_define_by_name($stmt3, "DE", $de);

	oci_execute($stmt3);
	oci_fetch($stmt3);

  // Write query on domer for seller's name and id
	$query2 = "SELECT d.email e ";
	$query2 .= "FROM domer d ";
	$query2 .= "WHERE d.user_id=$s";

	$stmt2 = oci_parse($conn, $query2);
	oci_define_by_name($stmt2, "E", $e2);

	oci_execute($stmt2);
	oci_fetch($stmt2);

  // Close the connection
	oci_close($conn);

	if ($_SESSION['user_id'] == $s) {
		$vendor_is_user =  true;
	}

	?>
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
		<?php
		if ($vendor_is_user) {
			print "
			<h1 class=\"cover-heading text-center\"><strong>Edit My Item</strong></h1>
			<hr/>
			";
		}
		?>
		<div class="col-sm-6">
			<img class="img-thumbnail" src=<?php print "\"server_images/$fn\""; ?> alt="Item Image" title=<?php print "\"$de\"" ?>>

			<div class="col-sm-11">
				<div id="my-thumbs-list" class="mThumbnailScroller" data-mts-axis="x">
					<ul>
						<?php
						$conn = oci_connect("guest", "guest", "xe")
						or die("Couldn't connect");

			  // Grab all of the photo filepaths excluding the main photo
						$query4  = "SELECT ip.filename ";
						$query4 .= "FROM item_photo ip ";
						$query4 .= "WHERE ip.item_id=$iid AND ip.filename!='$fn'";

			  //print $query4;

						$stmt4 = oci_parse($conn, $query4);

						oci_execute($stmt4);
						$nrows = oci_fetch_all($stmt4, $res);

						if ($nrows > 0)
						{
							for ($i=0; $i<$nrows; $i++)
							{
								reset($res);
								print "<li><a href=\"#\"><img id=\"scrimg\" src=";
								while ($column=each($res))
								{
									$data = $column['value'];
									print "\"server_images/$data[$i]\"";
								}
								print "/></a></li>\n";
							}
						}
						else
						{
				// There are no additional images, print the no images picture
							print "<li><a href=\"#\"><img id=\"scrimg\" src=\"images/no-image.jpg\"/></a></li>\n";
						}

						oci_close($conn);
						?>
					</ul>
				</div>
			</div>
		</div> <!-- END col-sm-6 -->

		<div class="col-sm-6">
			<div class="col-sm-11">
				<h1 class="cover-heading text-left"><?php print "$n"; ?></h1>
				<div class="col-sm-8">
					<p class="text-left"><?php print "$d"; ?></p>
				</div>  
				<div class="col-sm-4">
					<?php
					if ($vendor_is_user)
					{
						print "<button class=\"btn btn-primary center disabled\" type=\"button\">Buy</button>";
					}
					else
					{
						print "<button class=\"btn btn-primary center\" type=\"button\">Buy</button>";
					}

					?>
				</div>
				<div class="col-sm-12">
					<hr/>
					<div class="col-sm-1">
					</div>
					<div class="col-sm-7">
						<?php
						$conn = oci_connect("guest", "guest", "xe")
							or die("Couldn't connect");

						$query8  = "SELECT COUNT(*) counter ";
						$query8 .= "FROM favorite ";
						$query8 .= "WHERE user_id=".$_SESSION['user_id']." AND item_id=$iid";

						$stmt8 = oci_parse($conn, $query8);
						oci_define_by_name($stmt8, "COUNTER", $counter);

						oci_execute($stmt8);
						oci_fetch($stmt8);

						$query7  = "SELECT status stat ";
						$query7 .= "FROM favorite ";
						$query7 .= "WHERE user_id=".$_SESSION['user_id']." AND item_id=$iid";

						$stmt7 = oci_parse($conn, $query7);
						oci_define_by_name($stmt7, "COUNTER", $counter);
						oci_define_by_name($stmt7, "STAT", $item_status);

						oci_execute($stmt7);
						oci_fetch($stmt7);

						$fbtn_class = "btn btn-success";
						$href_open = "<a href=\"favorite_backend.php?fav=1&iid=$iid\">";
						$href_close = "</a>";
						$fbtn_text = "Favorite This Item";
						if ($item_status == 1)
						{
							// The item is already favorited, switch to "Unfavorite"
							$fbtn_text = "Remove Favorite Status";
							$fbtn_class = "btn btn-default";
							$href_open = "<a href=\"favorite_backend.php?fav=2&iid=$iid\">";
						}
						if ($vendor_is_user)
						{
							$fbtn_class .= " disabled";
							$href_open = "";
							$href_close = "";
						}
						print "$href_open <button class=\"$fbtn_class\" type=\"button\">$fbtn_text</button> $href_close \n";
						?>
					</div>
					<div class="col-sm-4">
						<?php
						$dbtn_class = "btn btn-danger";
						$href_open = "<a href=\"favorite_backend.php?fav=0&iid=$iid\">";
						$href_close = "</a>";
						$dbtn_text = "Dislike this Item";
						if ($item_status == 0 && $counter > 0)
						{
							// The item is already favorited, switch to "Unfavorite"
							$dbtn_text = "Remove Dislike Status";
							$dbtn_class = "btn btn-default";
							$href_open = "<a href=\"favorite_backend.php?fav=2&iid=$iid\">";
						}
						if ($vendor_is_user)
						{
							$dbtn_class .= " disabled";
							$href_open = "";
							$href_close = "";
						} 
						print "$href_open <button class=\"$dbtn_class\" type=\"button\">$dbtn_text</button> $href_close \n";
						?>        
					</div>
				</div>
				<div class="col-sm-12">
					<hr/>
					<h4 class="text-left">Item Properties:</h4> 
					<div class="col-sm-4">
						<h5 class="text-left">Price:</h5>
						<p class="text-left"><small>$<?php print "$p"; ?>.00</small></p>
					</div>
					<div class="col-sm-4">
						<h5 class="text">Condition:</h5>
						<span class="shams">
							<?php
							$newspan = "<span style=\"width:".(16*$c)."px;\"></span>";
							print $newspan;
							?>
						</span>
					</div>
					<div class="col-sm-4">
						<h5 class="text">Sell-by Date:</h5>
						<p class="text-left"><small><?php print "$e"; ?></small></p>
					</div>
				</div> <!-- END col-sm-12 -->
				<div class="col-sm-12">
					<hr/>
					<h4 class="text-left">Seller:</h4>
					<div class="col-sm-4">
						<h5 class="text-left">Email:</h5>
						<p class="text-left"><small><?php print "$e2"; ?></small></p>
					</div>
					<div class="col-sm-4">
						<h5 class="text-left">Follow-Up Rate:</h5>
						<p class="text-left">
							<?php
							$conn = oci_connect("guest", "guest", "xe")
							or die("Couldn't connect");
							$query5 = "SELECT COUNT(*) scot FROM transaction WHERE (buyer_id=$s OR seller_id=$s) AND status=1";
							$stmt5 = oci_parse($conn, $query5);
							oci_define_by_name($stmt5, "SCOT", $scot);
							oci_execute($stmt5);
							oci_fetch($stmt5);

							$query6 = "SELECT COUNT(*) scof FROM transaction WHERE (buyer_id=$s OR seller_id=$s) AND status=0";
							$stmt6 = oci_parse($conn, $query6);
							oci_define_by_name($stmt6, "SCOF", $scof);
							oci_execute($stmt6);
							oci_fetch($stmt6);

							$ratio = 1;
							if ($scot == 0 && $scof == 0)
							{
								print "<small><small>No seller history.</small></small>";
							}
							else
							{
								$ratio = $scot / ($scot + $scof);
								$percent = $ratio * 100;
								print "<small>" . round($percent) . "%</small>";
							}

							oci_close($conn);
							?>
						</p>
					</div>
					<div class="col-sm-4">
						<h5></h5>
						<?php
						if ($vendor_is_user)
						{
							print "<button class=\"btn btn-primary disabled\" type=\"button\">Message the Seller</button>";
						}
						else
						{
							print "<button class=\"btn btn-primary\" type=\"button\">Message the Seller</button>";
						}
						?>
					</div>
				</div> <!-- END col-sm-12 -->
				<div class="col-sm-12">
					<?php
					if ($vendor_is_user)
					{
						print "
						<hr/>
						<form class=\"form-photo\" action=\"upload_photo_backend.php?iid=$iid\" method=\"post\" enctype=\"multipart/form-data\">
							<div class=\"form-group\">
								<label for=\"inputItemPhoto\">Upload Another Photo</label>
								<input type=\"file\" class=\"form-control-file\" id=\"inputItemPhoto\" name=\"itemPhoto\">
							</div>
							<button type=\"submit\" class=\"btn btn-default\">Add Photo</button>
						</form>
						";
					}
					?>
				</div> <!-- END col-sm-12 -->
			</div> <!-- END col-sm-12 -->
		</div> <!-- This is the end of the major content -->

		<?php
		if ($vendor_is_user)
		{
			print "
			<div class=\"col-sm-12\" style=\"text-align:center;\">
				<hr/>
				<a href=\"delete_item_backend.php?iid=$iid&sid=$s\">
					<button type=\"button\" class=\"btn btn-danger\"><strong>DELETE THIS ITEM</strong></button>
				</a>
				<p class=\"text-danger\"><strong><br/>WARNING!!! This will permanently delete this item from the website!</strong></p>
			</div>
			";
		}
		?>
	</div> <!-- END container -->

	<hr/>

	<footer>
		<p>Made with &lt;3 at Notre Dame, by Thomas, Spencer, and David.</p>
	</footer>

	<abbr>
	</abbr>

<!-- Bootstrap core JavaScript
	================================================== -->
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
