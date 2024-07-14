<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" href="assets/blog/img/favicon.ico"/>

    <title>T-Shirt Shop </title>

    <!-- Bootstrap core CSS -->
    <link href="assets/blog/css/bootstrap.css" rel="stylesheet">

    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/blog/css/main.css" rel="stylesheet">
    <style>
      .loader {
        width: 48px;
        height: 48px;
        border: 5px solid #FFF;
        border-bottom-color: transparent;
        border-radius: 50%;
        display: inline-block;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }
        100% {
            transform: rotate(360deg);
        }
      }	
    </style>

    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="assets/blog/js/hover.zoom.js"></script>
    <script src="assets/blog/js/hover.zoom.conf.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Static navbar -->
    <div class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php">T-Shirt Shop</a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
          <li><a href="keranjang.php"><i class="fas fa-shopping-cart"></i> Keranjang</a></li>
          <li><a href="index.php"><i class="fas fa-tshirt"></i> Produk</a></li>
          <li><a href="profile.php"><i class="fas fa-user"></i> Profile</a></li>         
          <li><a href="history-pesanan.php"><i class="fas fa-user"></i> History Pesanan</a></li>         
          <li><a href="check-pesanan.php"><i class="fas fa-search"></i>Check Pesanan</a></li>   
          <?php if(isset($_SESSION['username'])){ ?>
      <li><a href="logout.php"><i class="fas fa-sign-in-alt"></i> Logout</a></li>
    <?php } else { ?>
      <li><a href="login.php"><i class="fas fa-user-alt"></i> Login</a></li>
    <?php } ?>       
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

