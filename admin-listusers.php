<?php
include 'koneksi.php';

if(!isset($_SESSION['username'])){
	header('location:login.php');
}

$sql = "SELECT * FROM users";
$result = mysqli_query($conn,$sql);

if(isset($_GET['id'])){
	$id = $_GET['id'];
	$sql = "DELETE FROM users WHERE id = $id";
	if(mysqli_query($conn,$sql)){
		echo "<script>window.location.href='admin-listusers.php';</script>";
	}
}
?>
<?php include 'views/admin/header.php'; ?>
<?php include 'views/admin/navbar.php'; ?>


    <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>List User</h2>
                        <h5>List Semua User Blog	 </h5>

                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
								 <div class="row">
		                 <div class="col-md-12">
		                     <!-- Advanced Tables -->
		                     <div class="panel panel-default">
		                         <div class="panel-heading">
		                              List User
		                         </div>
		                         <div class="panel-body">
		                             <div class="table-responsive">
		                                 <table class="table table-striped table-bordered table-hover" id="dataTables-example">
		                                     <thead>
		                                         <tr>
		                                             <th>#</th>
		                                             <th>Nama</th>
		                                             <th>Email</th>
		                                             <th>Role</th>
		                                             <th>Opsi</th>
		                                         </tr>
		                                     </thead>
		                                     <tbody>
																					 <?php $no = 1;?>
																					 <?php  while ($row = $result->fetch_assoc()) { ?>

		                                         <tr class="odd gradeX">
		                                             <td><?=$no?></td>
		                                             <td><?=$row['username']?></td>
		                                             <td><?=$row['email']?></td>
																								 <?php if($row['role'] == 1){ ?>
		                                             <td>User Admin</td>
																								 <?php }else{ ?>
																								 <td>User Bukutamu</td>
																								 <?php } ?>
		                                             <td>
																									 <div class="btn-group">
																										 <a href="admin-listusers.php?id=<?=$row['id']?>" class="btn btn-danger delete" Onclick="ConfirmDelete()">Delete</a>
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
