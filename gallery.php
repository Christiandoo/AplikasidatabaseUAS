<?php
include 'koneksi.php';

$sql_gallery = "SELECT * FROM gallery";
$result_gallery = mysqli_query($conn,$sql_gallery);
?>

<?php include 'views/blog/header.php'; ?>

<div class="container pt">
  <div class="row mt centered">
    <?php  while ($row = $result_gallery->fetch_assoc()) { ?>
    <div class="col-lg-4">
      <a class="zoom green" href="upload/<?=$row['nama_file']?>"><img class="img-responsive" src="upload/<?=$row['nama_file']?>" /></a>
      <p align="center"><?=$row['judul']?></p>
    </div>
  <?php } ?>
</div><!-- /container -->

<?php include 'views/blog/footer.php'; ?>
