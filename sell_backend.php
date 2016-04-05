<?php

// Start a session
session_start();

// Connect to the database
$conn = oci_connect('guest', 'guest', 'localhost/XE');
if (!$conn) {
	$e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

oci_fetch($query);

// Get the variables
$seller_id = $_SESSION['user_id']; //NEED TO SET THIS ON ON THE SIGN IN BACKEND
$name = $_POST[""];
$condition = $_POST[""];
$description = $_POST[""];
$price = $_POST[""];
$end_time = $_POST[""];

// Add the item to the DB
$query = oci_parse($conn, 'insert into item (seller_id, name, condition, description, price, end_time) values(:seller_id, :name, :condition, :description, :price, :end_time)');
oci_bind_by_name($query, ":seller_id", $seller_id)
oci_bind_by_name($query, ":name", $name);
oci_bind_by_name($query, ":condition", $condition);
oci_bind_by_name($query, ":description", $description);
oci_bind_by_name($query, ":price", $price);
oci_bind_by_name($query, "end_time", $end_time);
$r = oci_execute($query);

// error catching
if (!$r) {
	echo oci_error($query);
}

oci_close($conn);

header('Location: home.html'); 

?>
