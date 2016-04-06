<?php

$old_password = $_POST["oldPass"];
$new_password = $_POST["password"];
$new_confirm = $_POST["confirmPasswors"];
$user_id = $_POST["user_id"];

// Connect to the database
$conn = oci_connect('guest', 'guest', 'localhost/XE');
if (!$conn) {
	$e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Get the hashed password
$query = oci_parse($conn, 'SELECT user_id u, password_hash p FROM domer WHERE email = :email');
oci_bind_by_name($query, ":email", $email);
oci_define_by_name($query, "P", $password_hash);
oci_define_by_name($query, "U", $user_id);
oci_execute($query);
oci_fetch($query);

if(password_verify($old_password, $password_hash)) {
	// they match so change
    // update statement
    oci_close($conn);
    header('Location: home.php');
}
else {
	// they don't match, redirect
	$_SESSION["msg"] = "Incorrect password";
    oci_close($conn);
	header('Location: account.php');
}

?>
