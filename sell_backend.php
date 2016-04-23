<?php

	// Start a session
	session_start();

	// Connect to the database
	$conn = oci_connect('guest', 'guest', 'localhost/XE');
	if (!$conn) {
		$e = oci_error();
		trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
	}

	$successval = 5;

	// Why was this line here? (below)
	//oci_fetch($query);

	// Get the variables
	$seller_id = $_SESSION["user_id"];
	$name = $_POST["itemName"];
	$condition = $_POST["inputItemCondition"];
	$description = $_POST["itemDescription"];
	$price = $_POST["itemPrice"];
	$end_time = $_POST["itemEndTime"];
	$item_photo = basename($_FILES["itemPhoto"]["name"]);

	// Fix apostrophes
	$name = str_replace("'", '', $name);
	$description = str_replace("'", '', $description);

	echo $end_time;
	echo $seller_id;
	echo $_SESSION["user_id"];
	echo "<br/>";

	// Add the item to the DB
	$query = oci_parse($conn, "INSERT INTO item (seller_id, name, condition, description, price, end_time) VALUES(:seller_id, :name, :condition, :description, :price, TO_DATE(:end_time, 'YYYY-MM-DD'))");
	oci_bind_by_name($query, ":seller_id", $seller_id);
	oci_bind_by_name($query, ":name", $name);
	oci_bind_by_name($query, ":condition", $condition);
	oci_bind_by_name($query, ":description", $description);
	oci_bind_by_name($query, ":price", $price);
	oci_bind_by_name($query, ":end_time", $end_time);
	$r = oci_execute($query);

	// error catching
	if (!$r) 
	{
		$e = oci_error($query);  // For oci_execute errors pass the statement handle
		print htmlentities($e['message']);
		print "\n<pre>\n";
		print htmlentities($e['sqltext']);
		printf("\n%".($e['offset']+1)."s", "^");
		print  "\n</pre>\n";

		$successval = 1;
	}

	if ($successval == 5);
	{
		// The new item will be the item with the highest ID number for that user, find it.
		$query1_inner = "SELECT item_id FROM item WHERE seller_id=$seller_id ORDER BY item_id DESC";
		$query1 = "SELECT item_id iid ";
		$query1 .= "FROM ($query1_inner)";
		$query1 .= "WHERE ROWNUM=1";

		$stmt1 = oci_parse($conn, $query1);

		oci_define_by_name($stmt1, "IID", $iid);

		oci_execute($stmt1);
		oci_fetch($stmt1);

	    // Nail down some of the file-related variables
	    $target_dir = "./server_images/";
	    $target_file = $target_dir . basename($_FILES["itemPhoto"]["name"]);
	    $uploadOk = 1;
	    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

	    $new_file = $seller_id . $iid . "01". "." . $imageFileType;
	    $new_filepath = $target_dir . $new_file;

		// Upload the image: code strongly based on W3Schools entry on PHP 5 file uploads


		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) 
		{
			$check = getimagesize($_FILES["itemPhoto"]["tmp_name"]);
			if($check !== false) {
				echo "File is an image - " . $check["mime"] . ".";
				$uploadOk = 1;
			} else {
				echo "File is not an image.<br/>";
				$uploadOk = 0;
			}
		}
		// Check if file already exists
		if (file_exists($new_filepath))
		{
			echo "File '$new_filepath' already exists.<br/>";
			$uploadOk = 0;
		}
		// Allow certain file formats
		if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
		{
			echo "Only JPG, JPEG, PNG & GIF files are allowed.<br/>";
			$uploadOk = 0;
		}
		// Check file size
		if ($_FILES["itemPhoto"]["size"] > 8 * 1024 * 1024) 
		{
			echo "Sorry, your file is too large (Max file size: 8 MB).";
			$uploadOk = 0;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) 
		{
			echo "Sorry, your file was not uploaded.<br/>";
		}
		else 
		{
			// if everything is ok, try to upload file
			if (move_uploaded_file($_FILES["itemPhoto"]["tmp_name"], $new_filepath)) 
			{
				echo "The file ". basename( $_FILES["itemPhoto"]["name"]). " has been uploaded as $new_file.<br/>";
				// Add the item_photo filepath to the DB
				$description = "Item photo descriptions are not supported yet";
				$query2 = oci_parse($conn, "INSERT INTO item_photo (item_id, filename, description) VALUES(:item_id, :filename, :description)");
				oci_bind_by_name($query2, ":item_id", $iid);
				oci_bind_by_name($query2, ":filename", $new_file);
				oci_bind_by_name($query2, ":description", $description);
				$r2 = oci_execute($query2);

				// error catching
				if (!$r2) 
				{
					$e = oci_error($query);  // For oci_execute errors pass the statement handle
					print htmlentities($e['message']);
					print "\n<pre>\n";
					print htmlentities($e['sqltext']);
					printf("\n%".($e['offset']+1)."s", "^");
					print  "\n</pre>\n";
				}

			}
			else
			{
				echo "Sorry, there was an error uploading your file.<br/>";
			}
		}
		if ($uploadOk == 0)
		{
			$successval = 7;
		}
	}

	// We don't need SQL anymore, shut it down
	oci_close($conn);


	header('Location: home.php?c='.$successval);

?>
