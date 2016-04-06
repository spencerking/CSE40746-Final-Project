<?php
    if (!isset($_SESSION['logged_in'])) {
        header('Location: signin.html');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
  <link rel="icon" href=""/>

  <title>NDBay - Features</title>

  <!-- Bootstrap core CSS -->
  <link href="styles/bootstrap.min.css" rel="stylesheet"/>

  <!-- Custom styles for this template -->
  <style>
  /* Move down content because we have a fixed navbar that is 50px tall */
  body {
    padding-top: 80px;
    padding-bottom: 20px;
  }
  footer {
    text-align: center;
  }
  </style>

  <script type="text/javascript">
    $(function() 
    {        
      $('input[type=submit]').click(function() 
      {
        $('p').html('<span class="shams">'+parseFloat($('input[name=amount]').val())+'</span>');
        $('span.shams').shams();
      });       
      $('input[type=submit]').click();
    });

    $.fn.shams = function() 
    {
      return $(this).each(function() 
      {
        $(this).html($('<span />').width(Math.max(0, (Math.min(5, parseFloat($(this).html())))) * 16));
      });
    };
    </script>
    <style type="text/css">
    span.shams, span.shams span {
      display: block;
      background: url(images/shams.png) 0 -16px repeat-x;
      width: 80px;
      height: 16px;
    }
    span.shams span {
      background-position: 0 0;
    }
  </style>

  <?php
    $conn = oci_connect("guest", "guest", "xe")
    or die("Couldn't connect");
    
    $query1 = "SELECT i.seller_id s, i.name n, i.condition c, i.description d, i.price p, i.end_time e ";
    $query1 .= "FROM item i ";
    $query1 .= "WHERE i.item_id=7";
    
    $stmt = oci_parse($conn, $query1);


    oci_define_by_name($stmt, "S", $s);
    oci_define_by_name($stmt, "N", $n);
    oci_define_by_name($stmt, "C", $c);
    oci_define_by_name($stmt, "D", $d);
    oci_define_by_name($stmt, "P", $p);
    oci_define_by_name($stmt, "E", $e);

    oci_execute($stmt);
    
    // Write query on item_photo for filepath

    // Write query on domer for seller's name and id

    oci_close($conn);
  ?>
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
          <li class="dropwdown">
            <a class="dropdown-toggle" data-toggle="dropdown" roles="button" aria-haspopup="true" aria-expanded="false">Settings<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="account.php">Account</a></li>
              <li><a href="">Sign out</a></li>
            </ul>
          </li>
        </ul>
        <form class="navbar-form navbar-right" role="search">
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
  <div class="col-sm-6">
    <img class="img-thumbnail" src="http://placehold.it/650x350" alt="Item Image">
  </div> <!-- END col-sm-6 -->

  <div class="col-sm-6">
    <div class="col-sm-12">
      <h1 class="cover-heading text-left"><?php echo $n ?></h1>
      <div class="col-sm-6">
        <p class="text-left"><?php echo $d ?></p>
      </div>  
      <div class="col-sm-6">
        <button class="btn btn-primary center" type="button">Buy It!!!</button>
      </div>
      <div class="col-sm-12">
        <hr/>
        <h4 class="text-left">Item Properties:</h4> 
        <div class="col-sm-6">
          <h5 class="text-left">Price:</h5>
          <p class="text-left"><?php echo $p ?></p>
        </div>
        <div class="col-sm-6">
          <h5 class="text">Condition:</h5>
          <span class="shams"><?php echo $c ?></span>
        </div>
      </div>
      <div class="col-sm-12">
        <hr/>
        <h4 class="text-left">Seller:</h4>
        <div class="col-sm-6">
          <h5 class="text-left">Email:</h5>
          <a href="#" class="text-left">mjordan@retirednbaplayer.com</a>
        </div>
        <div class="col-sm-6">
          <h5 name="This is here to push the message button down a little bit"></h5>
          <button class="btn btn-primary" type="button">Message the Seller</button>
        </div>
      </div>
    </div>
  </div> <!-- END col-sm-6 -->

</div> <!-- END container -->

<hr/>

<footer>
  <p>Made with &lt;3 at Notre Dame, by Thomas, Spencer, and David.</p>
</footer>

<abbr>
</abbr>

<!-- Bootstrap core JavaScript
  ================================================== -->
  <script src="js/jquery-2.2.2.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
</body>
</html>