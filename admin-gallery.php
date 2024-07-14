<?php
include 'koneksi.php';

if(!isset($_SESSION['username'])){
	header('location:login.php');
}

if(isset($_POST['submit'])){
	$ekstensi_diperbolehkan	= array('png','jpg');
				$nama = $_FILES['file']['name'];
				$judul = $_POST['judul'];
				$tgl = date('Y-m-d H:i:s');
				$x = explode('.', $nama);
				$ekstensi = strtolower(end($x));
				$ukuran	= $_FILES['file']['size'];
				$file_tmp = $_FILES['file']['tmp_name'];

				if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
					if($ukuran < 1044070){
						move_uploaded_file($file_tmp, 'upload/'.$nama);
						$sql = "INSERT INTO gallery VALUES('','$nama','$judul','$tgl')";
						$query = mysqli_query($conn,$sql);
						if($query){
							echo '<script>alert("FILE BERHASIL DI UPLOAD");window.location.href="admin-gallery.php"</script>';
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
                                            <input class="form-control" name="judul" required autofocus />

                                        </div>
                                        <div class="form-group">
                                            <label>Upload Gambar</label>
                                            <input type="file" name="file">
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
