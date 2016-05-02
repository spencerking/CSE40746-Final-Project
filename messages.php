<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  header('Location: signin.html');
}

  // Connect to the database
$conn = oci_connect('guest', 'guest', 'localhost/XE');
if (!$conn) {
  $e = oci_error();
  trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$user_id = $_SESSION["user_id"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <meta name="description" content="">
  <meta name="author" content="">

  <title>NDBay - Messages</title>

  <!-- Bootstrap core CSS -->
  <link href="styles/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="styles/messages.css" rel="stylesheet">
  <style>
    /* Move down content because we have a fixed navbar that is 50px tall */
    body {
      padding-top: 120px;
      padding-bottom: 20px;
    }
    footer {
      text-align: center;
    }
    .chat-title h1 {
      color: white;
    }
  </style>
  <link rel="stylesheet" href="styles/freelancer.css"/>

  <!-- Custom Fonts -->
  <link href="styles/font-awesome.min.css" rel="stylesheet">
  <link href="http://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
  <link href="http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">
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
        <a class="navbar-brand" href="home.php"><img style="position:relative; top:-12.5px;" height="50px" width="auto" src="images/NDBayLogo.png"/></a>
      </div>
      <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav navbar-right">
          <li>
            <form class="navbar-form" action="search.php" role="search" method="post">
              <div class="form-group">
                <input type="text" class="form-control" name="search" placeholder="Search Items">
              </div>
              <button type="submit" class="btn btn-default">Go</button>
            </form>
          </li>
          <li><a href="sell.php">Sell</a></li>
          <li><a href="browse.php">Browse</a></li>
          <li><a href="favorites.php">Favorites</a></li>
          <li class="active"><a href="messages.php">Messages</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" roles="button" aria-haspopup="true" aria-expanded="false">
              <?php
              $conn = oci_connect("guest", "guest", "xe")
              or die("Couldn't connect");
              $query1 = "SELECT email email FROM domer WHERE user_id='".$_SESSION['user_id']."'";
              $stmt1 = oci_parse($conn, $query1);
              oci_define_by_name($stmt1, "EMAIL", $email);
              oci_execute($stmt1);
              oci_fetch($stmt1);
              print "$email ";
              oci_close($conn);
              ?>
              <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li><a href="account.php">Account</a></li>
              <li><a href="signout_backend.php">Sign out</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="chat">
    <div class="chat-title">
      <?php
      $conn = oci_connect("guest", "guest", "xe")
      or die("Couldn't connect");
      $query1 = "SELECT email email FROM domer WHERE user_id='".$_SESSION['user_id']."'";
      $stmt1 = oci_parse($conn, $query1);
      oci_define_by_name($stmt1, "EMAIL", $email);
      oci_execute($stmt1);
      oci_fetch($stmt1);
      print "<h1>$email</h1>";
      oci_close($conn);
      ?>
      <h2>Online</h2>
    </div>
    <div class="messages">
      <div class="messages-content"></div>
    </div>
    <div class="message-box">
      <textarea type="text" class="message-input" placeholder="Type message..."></textarea>
      <button type="submit" class="message-submit">Send</button>
    </div>

    <div class="bg"></div>
  </div>

  <!-- Bootstrap core JavaScript
  ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="js/jquery-2.2.2.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/socket.io.js"></script>
  <script src="js/messages.js"></script>

  <?php
  echo "<script>";

  echo "function initSocket(socket) {";
    echo "socket.on('update', function(data) {";
      // query the db
      // add a new list item with the returned message text
    echo "});";
  echo "}";

  echo "var posting = $.post('http://52.34.131.50:8163/', {user_id: ";
  echo $user_id;
  echo "});";

  // echo "posting.done(function( data ) {";
  // echo "var content = $( data ).find( '#result' );";
  // echo "$( '#result' ).empty().append( content );";
  // echo "});";

  echo "posting.done(function ( data ) {";
  echo "var content = $( data ).find( '#output_contacts' );";
  // need to figure out how to generate the list
  // don't want to just output straight from the db
  echo "});";

  echo "init();";

  echo "</script>";
  ?>

</body>
</html>
