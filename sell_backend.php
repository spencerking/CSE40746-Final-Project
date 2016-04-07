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
$seller_id = $_SESSION["user_id"];
$name = $_POST["itemName"];
$condition = $_POST["inputItemCondition"];
$description = $_POST["itemDescription"];
$price = $_POST["itemPrice"];
$end_time = $_POST["itemEndTime"];
$item_photo = $_POST['itemPhoto'];

echo $end_time;
echo $seller_id;
echo $_SESSION["user_id"];

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
if (!$r) {
	$e = oci_error($query);  // For oci_execute errors pass the statement handle
    print htmlentities($e['message']);
    print "\n<pre>\n";
    print htmlentities($e['sqltext']);
    printf("\n%".($e['offset']+1)."s", "^");
    print  "\n</pre>\n";
}

// The new item will be the item with the highest ID number for that user, find it.
$query1 = "SELECT i.item_id iid ";
$query1 .= "FROM item i, item it ";
$query1 .= "WHERE i.item_id>=it.item_id AND i.seller_id=$seller_id";

$stmt1 = oci_parse($conn, $query1);

oci_define_by_name($stmt1, "IID", $iid);

oci_execute($stmt1);
oci_fetch($stmt1);

// Add the item_photo filepath to the DB
$description = "Item photo descriptions are not supported yet";
$query2 = oci_parse($conn, "INSERT INTO item_photo (item_id, filename, description) VALUES(:item_id, :filename, :description)");
oci_bind_by_name($query2, ":item_id", $iid);
oci_bind_by_name($query2, ":filename", $item_photo);
oci_bind_by_name($query2, ":description", $description);
$r2 = oci_execute($query2);

// error catching
if (!$r2) {
	$e = oci_error($query);  // For oci_execute errors pass the statement handle
    print htmlentities($e['message']);
    print "\n<pre>\n";
    print htmlentities($e['sqltext']);
    printf("\n%".($e['offset']+1)."s", "^");
    print  "\n</pre>\n";
}

oci_close($conn);

// Upload the image: code based on W3Schools entry on PHP 5 file uploads
$target_dir = "../server_images/";
$target_file = $target_dir . basename($_FILES["itemPhoto"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["itemPhoto"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["itemPhoto"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["itemPhoto"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}


// header('Location: home.php');

?>
