<?php
include 'koneksi.php';

if(!isset($_SESSION['username'])){
	header('location:login.php');
}

$sql = "SELECT komentar.id,komentar.nama,komentar.email,komentar.komentar,komentar.tgl_komentar FROM komentar";
$result = mysqli_query($conn,$sql);

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$sql = "DELETE FROM komentar WHERE id = $id";
	if(mysqli_query($conn,$sql)){
		echo "<script>window.location.href='admin-listkomentar.php';</script>";
	}
}
?>
<?php include 'views/admin/header.php'; ?>
<?php include 'views/admin/navbar.php'; ?>


    <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>List Komentar</h2>
                        <h5>List Semua Komentar	 </h5>

                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
								 <div class="row">
		                 <div class="col-md-12">
		                     <!-- Advanced Tables -->
		                     <div class="panel panel-default">
		                         <div class="panel-heading">
		                              List Post
		                         </div>
		                         <div class="panel-body">
		                             <div class="table-responsive">
		                                 <table class="table table-striped table-bordered table-hover" id="dataTables-example">
		                                     <thead>
		                                         <tr>
		                                             <th>#</th>
		                                             <th>Nama</th>
		                                             <th>Email</th>
		                                             <th>Komentar</th>
		                                             <th>Tanggal Komentar</th>
		                                             <th>Post</th>
		                                             <th>Opsi</th>
		                                         </tr>
		                                     </thead>
		                                     <tbody>
																					 <?php $no = 1;?>
																					 <?php  while ($row = $result->fetch_assoc()) { ?>

		                                         <tr class="odd gradeX">
		                                             <td><?=$no?></td>
		                                             <td><?=$row['nama']?></td>
		                                             <td><?=$row['email']?></td>
		                                             <td><?=substr($row['komentar'],0,50)?></td>
		                                             <td><?=$row['tgl_komentar']?></td>
		                                             <td><?=$row['komentar']?></td>
		                                             <td>
																									 <div class="btn-group">
																										 <a href="admin-listkomentar.php?id=<?=$row['id']?>" class="btn btn-danger delete" Onclick="ConfirmDelete()">Delete</a>
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
