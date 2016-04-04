<?php

// Start a session
session_start();

$email = $_POST["email"];
$password = $_POST["password"];

// Connect to the database
$conn = oci_connect('guest', 'guest', 'localhost/XE');
if (!$conn) {
	$e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Get the hashed password
$query = oci_parse($conn, 'select password_hash from domer where email = :email');
oci_bind_by_name($query, ":email", $email);
oci_define_by_name($query, "password_hash", $password_hash);
oci_execute($query);
oci_fetch($query);

oci_close($conn);

if (password_verify($password, $password_hash)) {
	// they match so login
	header('Location: '); // WHERE DO WE WANT TO REDIRECT TO?
}
else {
	// they don't match, redirect
	$_SESSION["msg"] = "Incorrect email or password";
	header('Location: signin.html'); // WHERE DO WE WANT TO REDIRECT TO?
}

?>