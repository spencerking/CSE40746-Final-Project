<?php
// require_once 'PHPMailer/PHPMailerAutoload.php';

// SMTP needs accurate times, and the PHP time zone MUST be set
date_default_timezone_set('Etc/UTC');

// Start a session
session_start();

$new_email = $_POST["email"];

// Connect to the database
$conn = oci_connect('guest', 'guest', 'localhost/XE');
if (!$conn) {
	$e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Check if the email already exists
$query = oci_parse($conn, 'select email e from domer where email = :new_email');
oci_bind_by_name($query, ":new_email", $new_email);
oci_define_by_name($query, "E", $email);
$r = oci_execute($query);
if (!$r) {
	echo oci_error($query);
}

oci_fetch($query);
echo $email;
echo $new_email;

// If the email already exists return an error message to the user
if (!strcmp($new_email, $email)) {
	// return an error
	$_SESSION["msg"] = "Email address is already registered";
	header('Location: signin.html'); // WHERE DO WE WANT TO REDIRECT TO?
	die();
}

// Create the password hash
$new_pass = password_hash($_POST["password"], PASSWORD_DEFAULT);

// If the username does not already exist add it to the db
$query = oci_parse($conn, 'insert into domer (password_hash, email) values(:new_pass, :new_email)');
oci_bind_by_name($query, ":new_pass", $new_pass);
oci_bind_by_name($query, ":new_email", $new_email);
oci_execute($query);

oci_close($conn);

// Email the user
/*
$mail = new PHPMailer;

$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';  					  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'ndbay16@gmail.com';                // SMTP username
$mail->Password = 'notredamebay';                     // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

$mail->setFrom('donotreply@ndbay.com', 'NDBay');
$mail->addAddress($new_email);     // Add a recipient
$mail->addReplyTo('donotreply@ndbay.com', 'DO NOT REPLY');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Welcome to NDBay!';
$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}
*/

$_SESSION["msg"] = "Your account has been created.";
header('Location: home.php'); // WHERE DO WE WANT TO REDIRECT TO?

?>
