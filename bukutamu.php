<?php
include 'koneksi.php';

if(!isset($_SESSION['username'])){
	echo "<script>alert('Anda Harus Login Dulu');window.location.href='login.php'</script>";
}

$sqll = "SELECT * FROM bukutamu ";
$result = mysqli_query($conn,$sqll);


if(isset($_POST['submit'])){
	$nama = $_POST['nama'];
	$email = $_POST['email'];
	$pesan = $_POST['pesan'];
	$tgl_bukutamu = date("d-m-Y");

	$sql = "INSERT INTO bukutamu VALUES('','$nama','$email','$pesan','$tgl_bukutamu')";
	if(mysqli_query($conn,$sql)){
		echo "<script>alert('Berhasil Menambah Bukutamu');window.location.href='bukutamu.php';</script>";
	}
}
?>
<?php include 'views/blog/header.php'; ?>
<div id="white">
    <div class="container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2">
        <h2>Daftar Tamu</h2><br>
        <form method="post">
        <div class="form-group">
          <label>Name</label>
          <input class="form-control" name="nama">
          <input class="form-control" type="hidden" name="id_post" value="<?=$detail['id']?>">
        </div>
        <div class="form-group">
          <label>Email</label>
          <input class="form-control" name="email">
        </div>
        <div class="form-group">
          <label>Pesan</label>
          <textarea class="form-control" name="pesan" rows="8" cols="10"></textarea>
        </div>
        <div class="form-group">
          <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </div>
      </form><hr>
      <table border="1" class="table table-striped" align-items="center">
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Pesan</th>
          <th>Tanggal</th>
        </tr>
        <?php $no = 1 ?>
        <?php  while ($row = $result->fetch_assoc()) { ?>
        <tr>
          <td><?=$no?></td>
          <td><?=$row['nama']?></td>
          <td><?=$row['email']?></td>
          <td><?=$row['pesan']?></td>
          <td><?=$row['tgl_bukutamu']?></td>
          <?php $no++ ?>
        </tr>
      <?php } ?>

      </table>

      </div>

    </div><!-- /row -->
    </div> <!-- /container -->
</div><!-- /white -->

<?php include 'views/blog/footer.php'; ?>
