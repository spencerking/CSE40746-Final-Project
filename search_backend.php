<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>NDBay - Search</title>

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
          <a class="navbar-brand" href="home.html">NDBay</a>
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
              <input type="text" class="form-control" name="search" placeholder="Search">
            </div>
            <button type="submit" class="btn btn-default">Go</button>
          </form>
        </div>
        </div>
      </div>
    </nav>

    <div class="container">

<?php

$conn = oci_connect('guest', 'guest', 'localhost/XE');
if (!$conn) {
    $e = oci_error();
    echo $e['message'];
    exit;
}

if (isset($_POST['search'])) {
    $searchText = $_POST['search'];
}
$query = 'SELECT name, condition, description, price, end_time FROM item WHERE LOWER(name) LIKE \'%'.$searchText.'%\'';
$stid = oci_parse($conn, $query);
$r = oci_execute($stid);

print '<div class="row">';
while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
    print '<div class="col-md-4">';
    print '<h2><a href="item.php">'.$row['NAME'].'</a></h2>';
    print '<h4>$'.$row['PRICE'].'.00</h4>';
    print '<p>'.$row['DESCRIPTION'].'</p>';
    print '</div>';
}
print '</div>';

oci_close($conn);

?>
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
