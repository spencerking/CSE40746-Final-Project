<?php
    session_start();
    if (!isset($_SESSION['logged_in'])) {
        header('Location: signin.html');
    }
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

    <title>NDBay - Account</title>

    <!-- Bootstrap core CSS -->
    <link href="styles/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="styles/account.css" rel="stylesheet">
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
      <h2>Transaction History</h2>
      <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#history">Transaction History</button>
      <div id="history" class="collapse">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit,
        sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
      </div>
      <h2>Change Password</h2>
      <button type="button" class="btn btn-info" data-toggle="collapse" data-target="#password">Change Password</button>
      <div id="password" class="collapse">
        <form class="form-signin" action="change_pass_backend.php" method="post">
          <label for="oldPass" class="sr-only">Old Password</label>
          <input type="password" id="oldPassword" name="oldPass" class="form-control" placeholder="Old Password" autofocus>
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="inputPassword" name="password" class="form-control" placeholder="New Password">
          <label for="inputConfirmPassword" class="sr-only">Confirm password</label>
          <input type="password" id="inputConfirmPassword" name="confirmPassword" class="form-control" placeholder="Confirm Password">
          <div class="error"><ul></ul></div>
          <button class="btn btn-lg btn-primary btn-block" type="submit">Submit</button>
        </form>
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