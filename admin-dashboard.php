<?php
include 'koneksi.php';
if(!isset($_SESSION['username'])){
	header('location:login.php');
}

$sql_user = "SELECT * FROM users";
$result_user = mysqli_query($conn,$sql_user);
$row_user = mysqli_num_rows($result_user);

$sql_post = "SELECT * FROM post_produk";
$result_post = mysqli_query($conn,$sql_post);
$row_post = mysqli_num_rows($result_post);

$sql_kategori = "SELECT * FROM kategori";
$result_kategori = mysqli_query($conn,$sql_kategori);
$row_kategori = mysqli_num_rows($result_kategori);

$sql_bukutamu = "SELECT * FROM bukutamu";
$result_bukutamu = mysqli_query($conn,$sql_bukutamu);
$row_bukutamu = mysqli_num_rows($result_bukutamu);
?>

<?php include 'views/admin/header.php'; ?>
<?php include 'views/admin/navbar.php'; ?>

        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Beranda Admin </h2>
                        <h5>Selamat Datang Admin, Suksesmu Karna Doa Orang Tuamu</h5>
                    </div>
                </div>
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-6">
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-red set-icon">
                    <i class="fa fa-edit"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text"><?=$row_post?> Jumlah produk</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa-bars"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text"><?=$row_kategori?> Jumlah kategori</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa fa-bell-o"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text"><?=$row_bukutamu?> transaksi</p>
                </div>
             </div>
		     </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">
			<div class="panel panel-back noti-box">
                <span class="icon-box bg-color-brown set-icon">
                    <i class="fa fa-users"></i>
                </span>
                <div class="text-box" >
                    <p class="main-text"><?=$row_user?> Users</p>
                </div>
             </div>
		     </div>
			</div>
                 <!-- /. ROW  -->
                <hr />
            </div>
         <!-- /. PAGE WRAPPER  -->
        </div>
<?php include 'views/admin/footer.php'; ?>
