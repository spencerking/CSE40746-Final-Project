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
    <style>
    /* Move down content because we have a fixed navbar that is 50px tall */
    body {
      padding-top: 50px;
      padding-bottom: 20px;
    }
    footer {
      text-align: center;
    }
    </style>
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
          <a class="navbar-brand" href="home.php">NDBay</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="sell.php">Sell</a></li>
            <li class="active"><a href="messages.php">Messages</a></li>
            <li class="dropdown">
              <a class="dropdown-toggle" data-toggle="dropdown" roles="button" aria-haspopup="true" aria-expanded="false">Settings<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="account.php">Account</a></li>
                <li><a href="">Sign out</a></li>
              </ul>
            </li>
          </ul>
          <form class="navbar-form navbar-right" action="search_backend.php" role="search" method="post">
            <div class="form-group">
              <input type="text" name="search" placeholder="Search" class="form-control">
            </div>
            <button type="submit" class="btn btn-default">Go</button>
          </form>
        </div>
        </div>
      </div>
    </nav>

    <div class="container">
      <h2>Messages</h2>

      <!-- Need to change all of the sql functions to oracle -->
      <div class="message-body">
        <div class="message-left">
            <ul>
                <?php

                    //show all the users chatting with
                    $query = oci_parse($conn, "SELECT * FROM domer WHERE user_id != :user_id");
                    oci_bind_by_name($query, ":user_id", $user_id);
                    oci_execute($query);

                    //display all the results
                    while (oci_fetch($query)) {
                        // echo
                    }
                ?>
            </ul>
        </div>

        <div class="message-right">
            <!-- display message -->
            <div class="display-message">
            <?php
                //check $_GET['id'] is set
                if (isset($_GET['id'])) {

                    // need to get the other user in the conversation
                    // I'm assuming this is the foreign key user_id in message table
                    // $user_two = trim(mysqli_real_escape_string($conn, $_GET['id']));

                    //check $user_two is valid
                    // HOW DO WE DISTINGUISH BETWEEN FOREIGN KEY user_id AND NORMAL user_id?????
                    $query = oci_parse($conn, "SELECT user_id FROM domer WHERE user_id = :user_two AND user_id != :user_id");
                    oci_bind_by_name($query, ":user_two", $user_two);
                    oci_bind_by_name($query, ":user_id", $user_id);
                    oci_execute($query);

                    //valid $user_two
                    // CHECK IF THERE IS oci_num_rows!!!!!!
                    if (mysqli_num_rows($query) == 1) {
                       
                        //check $user_id and $user_two has conversation or not if no start one
                        // FOREIGN KEY CONFUSION
                        $conver = oci_parse($conn, "SELECT * FROM message WHERE (user_id = :user_id AND user_id = :user_two) OR (user_id = :user_two AND user_id = :user_id)");
                        oci_bind_by_name($query, ":user_id", $user_id);
                        oci_bind_by_name($query, ":user_two", $user_two);
                        oci_execute($query);
                        
                        //they have a conversation
                        if (mysqli_num_rows($conver) == 1) {
                            //fetch the converstaion id
                            $fetch = mysqli_fetch_assoc($conver);
                            $conversation_id = $fetch['id'];
                        }
                        //they do not have a conversation
                        else {
                            //start a new converstaion and fetch its id
                            $query = mysqli_query($conn, "INSERT INTO message VALUES ('','$user_id',$user_two)");
                            $conversation_id = mysqli_insert_id($con);
                        }
                    }
                    else {
                        die("Invalid $_GET ID.");
                    }
                }
                else {
                    die("Click On the Person to start Chatting.");
                }
            ?>
            </div>

    </div>

      <hr>

      <footer>
        <p>Made with &lt;3 at Notre Dame, by Thomas, Spencer, and David.</p>
      </footer>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery-2.2.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>