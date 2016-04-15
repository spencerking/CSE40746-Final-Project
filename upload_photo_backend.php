<?php

    // Start a session
    session_start();

    // Connect to the database
    $conn = oci_connect('guest', 'guest', 'localhost/XE');
    if (!$conn) {
    	$e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Why was this line here? (below)
    //oci_fetch($query);

    // Get the variables
    $iid = $_GET['iid'];
    $sid = $_SESSION['user_id'];
    $item_photo = basename($_FILES["itemPhoto"]["name"]);

    
    // Nail down some of the file-related variables
    $target_dir = "./server_images/";
    $target_file = $target_dir . basename($_FILES["itemPhoto"]["name"]);
    $uploadOk = 1;
    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

    // TODO: Count the number of item photos for this item`
    $new_file = $seller_id . $iid . "01." . $imageFileType;
    $new_filepath = $target_dir . $new_file;

    // Upload the image: code strongly based on W3Schools entry on PHP 5 file uploads

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
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
    if (file_exists($new_filepath)) {
        echo "File already exists.<br/>";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" )
    {
        echo "Only JPG, JPEG, PNG & GIF files are allowed.<br/>";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) 
    {
        echo "Sorry, your file was not uploaded.<br/>";
    }
    // if everything is ok, try to upload file
    else 
    {
        if (move_uploaded_file($_FILES["itemPhoto"]["tmp_name"], $new_filepath)) 
        {
            echo "The file ". basename( $_FILES["itemPhoto"]["name"]). " has been uploaded.<br/>";
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

    // We don't need SQL anymore, shut it down
    oci_close($conn);

    //header("Location: item.php?iid=$iid");

?>
