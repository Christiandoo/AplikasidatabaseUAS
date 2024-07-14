<?php
include 'koneksi.php';

if(!isset($_SESSION['username'])){
	header('location:login.php');
}
$id = $_GET['id'];
$sqll = "SELECT * FROM gallery WHERE id = $id";
$result = mysqli_query($conn,$sqll);
$detail = mysqli_fetch_array($result,MYSQLI_ASSOC);
$hapus = "upload/".$detail['nama_file'];
if(isset($_POST['submit'])){
	unlink($hapus);
	$ekstensi_diperbolehkan	= array('png','jpg','jpeg');
				$nama = $_FILES['file']['name'];
				$id = $_POST['id'];
				$judul = $_POST['judul'];
				$tgl = date('Y-m-d H:i:s');
				$x = explode('.', $nama);
				$ekstensi = strtolower(end($x));
				$ukuran	= $_FILES['file']['size'];
				$file_tmp = $_FILES['file']['tmp_name'];

				if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
					if($ukuran < 1044070){
						move_uploaded_file($file_tmp, 'upload/'.$nama);
						$sql = "UPDATE gallery SET nama_file = '$nama',judul='$judul',tgl_gallery='$tgl' WHERE id = $id";
						$query = mysqli_query($conn,$sql);
						if($query){
							echo '<script>alert("FILE BERHASIL DI UPLOAD");window.location.href="admin-listgallery.php"</script>';
						}else{
							echo '<script>alert("GAGAL MENGUPLOAD GAMBAR");history.back(-1)</script>';
						}
					}else{
						echo '<script>alert("UKURAN FILE TERLALU BESAR");history.back(-1)</script>';
					}
				}else{
					echo '<script>alert("EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN");history.back(-1)</script>';
			}
}
?>
<?php include 'views/admin/header.php'; ?>
<?php include 'views/admin/navbar.php'; ?>


    <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>Gallery</h2>
                        <h5>Silahkan Tambah Gallery Dibawah Ini .	 </h5>

                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
               <div class="row">
                <div class="col-md-12">
                    <!-- Form Elements -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Tambah Gallery
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-9">

                                    <form role="form" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Judul</label>
                                            <input class="form-control" name="judul" value="<?=$detail['judul']?>" />
                                            <input class="form-control" type="hidden" name="id" value="<?=$detail['id']?>" />

                                        </div>
                                        <div class="form-group">
                                            <label>Upload Gambar</label>
                                            <input type="file" name="file">
                                        </div>
                                        <div class="form-group">
                                            <label>Gambar</label><br>
																							<img src="upload/<?=$detail['nama_file']?>" width="50px" height="50px">
                                        </div>
																				<div class="form-group">
										    									<button type="reset" class="btn btn-primary" name="reset">Reset</button>
										    									<button type="submit" class="btn btn-success right" name="submit">Submit</button>
										    								</div>
    							</div>

                            </div>
                        </div>
                    </div>
                     <!-- End Form Elements -->
                </div>
            </div>
                <!-- /. ROW  -->
                <!-- /. ROW  -->
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
<?php include 'views/admin/footer.php'; ?>
