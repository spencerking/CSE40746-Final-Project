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

	<title>NDBay - Features</title>

	<!-- Bootstrap core CSS -->
	<link href="styles/bootstrap.min.css" rel="stylesheet"/>
	<!-- jQuery links -->
	<link rel="stylesheet" href="styles/jquery.mThumbnailScroller.css"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
	<script src="js/jquery.mThumbnailScroller.min.js"></script>

	<!-- Custom styles for this template -->
	<style>
		/* Move down content because we have a fixed navbar that is 50px tall */
		body {
			padding-top: 80px;
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

	<script type="text/javascript">
		$(document).ready(function() 
		{    		
			$('span.shams').shams();
		});

		$.fn.shams = function()
		{
			return $(this).each(function()
			{
				var val = parseFloat($(this).html());
				var size = Math.max(0, (Math.min(5, val))) * 16;
	        	// Create stars holder
	        	var $span = $('<span />').width(size);
	        	// Replace the numerical value with stars
	        	$(this).html($span);
	        });
		}
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

	if ($_SESSION['user_id'] == $s)
	{
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
							print "$email"
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

<?php
if ($vendor_is_user)
{
	print "
	<h1 class=\"cover-heading text-center\"><strong>Edit My Item</strong></h1>
	<hr/>
	";
}
?>
<div class="container">
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
				<div class="col-sm-6">
					<?php
						print "<a href=\"favorite_backend.php?fav=1&iid=$iid\"><button class=\"btn btn-success\" type=\"button\">Favorite This Item</button></a>\n";
					?>
				</div>
				<div class="col-sm-6">
					<?php
						print "<a href=\"favorite_backend.php?fav=0&iid=$iid\"><button class=\"btn btn-danger\" type=\"button\">Favorite This Item</button></a>\n";
					?>				
				</div>
			</div>
			<div class="col-sm-12">
				<hr/>
				<h4 class="text-left">Item Properties:</h4> 
				<div class="col-sm-4">
					<h5 class="text-left">Price:</h5>
					<p class="text-left">$<?php print "$p"; ?>.00</p>
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
					<p class="text-left"><?php print "$e"; ?></p>
				</div>
			</div> <!-- END col-sm-12 -->
			<div class="col-sm-12">
				<hr/>
				<h4 class="text-left">Seller:</h4>
				<div class="col-sm-4">
					<h5 class="text-left">Email:</h5>
					<p class="text-left"><?php print "$e2"; ?></p>
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
							print "<small>No seller history.</small>";
						}
						else
						{
							$ratio = $scot / ($scot + $scof);
							$percent = $ratio * 100;
							print round($percent) . "%";
						}

						oci_close($conn);
						?>
					</p>
				</div>
				<div class="col-sm-4">
					<h5 name="This is here to push the message button down a little bit"></h5>
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
	</div>

</div> <!-- END container -->

<hr/>

<footer>
	<p>Made with &lt;3 at Notre Dame, by Thomas, Spencer, and David.</p>
</footer>

<abbr>
</abbr>

<!-- Bootstrap core JavaScript
	================================================== -->
	<script src="js/jquery-2.2.2.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
</body>
</html>
