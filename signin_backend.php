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
$query = oci_parse($conn, 'select user_id, password_hash from domer where email = :email');
oci_bind_by_name($query, ":email", $email);
oci_define_by_name($query, "password_hash", $password_hash);
oci_define_by_name($query, "user_id", $user_id);
oci_execute($query);
oci_fetch($query);

oci_close($conn);


$new_pass = password_hash($_POST["password"], PASSWORD_BCRYPT);

if (strcmp($new_pass, $password_hash)) {
        // they match so login
        $_SESSION["logged_in"] = 1;
        $_SESSION["user_id"] = $user_id;
        header('Location: home.html');
}
else {
	// they don't match, redirect
	$_SESSION["msg"] = "Incorrect email or password";
	header('Location: signin.html'); // WHERE DO WE WANT TO REDIRECT TO?
}

?>
