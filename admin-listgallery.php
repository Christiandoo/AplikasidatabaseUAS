<?php
include 'koneksi.php';

if(!isset($_SESSION['username'])){
	header('location:login.php');
}

$sql = "SELECT * FROM gallery";
$result = mysqli_query($conn,$sql);

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$sqll = "SELECT * FROM gallery WHERE id = $id";
	$result = mysqli_query($conn,$sqll);
	$detail = mysqli_fetch_array($result,MYSQLI_ASSOC);
	$hapus = "upload/".$detail['nama_file'];
	unlink($hapus);
	$sql = "DELETE FROM gallery WHERE id = $id";
	if(mysqli_query($conn,$sql)){
		echo "<script>window.location.href='admin-listgallery.php';</script>";
	}
}
?>
<?php include 'views/admin/header.php'; ?>
<?php include 'views/admin/navbar.php'; ?>


    <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>List Gallery</h2>
                        <h5>List Semua Gallery Blog	 </h5>

                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
								 <div class="row">
		                 <div class="col-md-12">
		                     <!-- Advanced Tables -->
		                     <div class="panel panel-default">
		                         <div class="panel-heading">
		                              List Gallery
		                         </div>
		                         <div class="panel-body">
		                             <div class="table-responsive">
		                                 <table class="table table-striped table-bordered table-hover" id="dataTables-example">
		                                     <thead>
		                                         <tr>
		                                             <th>#</th>
		                                             <th>Image</th>
		                                             <th>Judul</th>
		                                             <th>Tanggal</th>
		                                             <th>Opsi</th>
		                                         </tr>
		                                     </thead>
		                                     <tbody>
																					 <?php $no = 1;?>
																					 <?php  while ($row = $result->fetch_assoc()) { ?>

		                                         <tr class="odd gradeX">
		                                             <td><?=$no?></td>
		                                             <td><img src="upload/<?=$row['nama_file']?>" width="50px" height="50px"></td>
		                                             <td><?=$row['judul']?></td>
		                                             <td><?=$row['tgl_gallery']?></td>
		                                             <td>
																									 <div class="btn-group">
																										 <a href="admin-editgallery.php?id=<?=$row['id']?>" class="btn btn-warning">Edit</a>
																										 <a href="admin-listgallery.php?id=<?=$row['id']?>" class="btn btn-danger delete" Onclick="ConfirmDelete()">Delete</a>
																									 </div>
																									 </td>
		                                         </tr>
																						 <?php $no++ ?>
																						 <?php } ?>
		                                     </tbody>
		                                 </table>
		                             </div>

		                         </div>
		                     </div>
		                     <!--End Advanced Tables -->
		                 </div>
		             </div>
                <!-- /. ROW  -->
                <!-- /. ROW  -->
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
<?php include 'views/admin/footer.php'; ?>
<script>
	function ConfirmDelete(){
		return confirm('Are you sure you want to delete?');
	}
</script>
