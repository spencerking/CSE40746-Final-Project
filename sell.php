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

    <title>NDBay - Sell</title>

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
    .form-sell {
      margin-top: 20px;
      max-width: 330px;
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
            <li class="active"><a href="sell.php">Sell</a></li>
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
              <input type="text" placeholder="Search" class="form-control">
            </div>
            <button type="submit" class="btn btn-default">Go</button>
          </form>
        </div>
        </div>
      </div>
    </nav>

    <div class="container">
      <form class="form-sell" action="sell_backend.php" method="post">
        <div class="form-group">
          <label for="inputItemName">Name</label>
          <input type="text" class="form-control" id="inputItemName" name="itemName">
        </div>
        <div class="form-group">
          <label for="inputItemCondition">Condition</label>
          <select name="inputItemCondition" class="form-control">
            <option value="1">Meh</option>
            <option value="2">Not Terrible</option>
            <option value="3">Pretty Okay</option>
            <option value="4">Great</option>
            <option value="5">Good as New</option>
          </select>
        </div>
        <div class="form-group">
          <label for="inputItemDescription">Description</label>
          <input type="textarea" class="form-control"  id="inputItemDescription" name="itemDescription">
        </div>
        <div class="form-group">
          <label for="inputItemPrice">Price</label>
          <div class="input-group">
            <span class="input-group-addon">$</span>
            <input type="number" class="form-control" min="0" id="inputItemPrice" name="itemPrice">
            <span class="input-group-addon">.00</span>
          </div>
        </div>
        <div class="form-group">
          <label for="inputItemEndTime">Sell-by Date</label>
          <input type="date" class="form-control" id="inputItemEndTime" name="itemEndTime">
        </div>
        <div class="form-group">
          <label for="inputItemPhoto">Upload Photo</label>
          <input type="file" class="form-control-file" id="itemPhoto" name="itemPhoto">
        </div>
        <div class="error"><ul></ul></div>
        <button type="submit" class="btn btn-primary">Create Listing</button>
      </form>

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
    <script src="js/jquery.validate.min.js"></script>

    <script>
    $('.form-sell').validate({
      errorContainer: $('.form-sell div.error'),
      errorLabelContainer: $('ul', $('.form-sell div.error')),
      wrapper: 'li',
      rules: {
        name: {
          required: true
        },
        price: {
          required: true
        }
      },
      messages: {
        name: {
          required: 'Name is required.'
        },
        price: {
          required: 'Price is required.'
        }
      }
    });
    </script>
  </body>
</html>
