<?php
	namespace NDBay_alerts;

	function print_alert($code)
	{	
		switch ($code) 
		{
		case 0:
			break;
		case 1:
			print "
			<div class=\"alert alert-danger\">
				<p>
					<strong>ERROR!!! Your item listing was not posted!</strong><br/>
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
				</p>
			</div>
			";
			break;
		case 6:
			print "
			<div class=\"alert alert-danger\">
				<p>
					<strong>ERROR!!! Your image did not upload</strong>
				</p>
			</div>
			";
			break;
		case 7:
			print "
			<div class=\"alert alert-warning\">
				<p>
					<strong>WARNING! Your item listing was posted without the image!</strong><br/>
					To upload other images, navigate to that item's web page.
				</p>
			</div>
			";
			break;
		case 8:
			print "
			<div class=\"alert alert-info\">
				<p>
					<strong>Preferences have been removed from this item.</strong><br/>
				</p>
			</div>
			";
			break;
		default:
			break;
		}
	}
?>