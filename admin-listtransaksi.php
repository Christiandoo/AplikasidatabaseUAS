<?php

include_once './model/Pesanan.php';

use FontLib\Table\Type\head;
use model\Pesanan;

include 'koneksi.php';

if(!isset($_SESSION['username'])){
	header('location:login.php');
}

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $pesananModel = new Pesanan($conn);
    $pesananModel->deletePesanan($id);
    if(!$pesananModel->error()) {
        header('location: admin-listtransaksi.php?');
    }
}

$status = 'Menunggu Pembayaran';

if(isset($_GET['status']) && in_array($_GET['status'], ['Dibayar', 'Diproses', 'dibayar', 'diproses'])) {
    $status = $_GET['status'];
}

$pesananModel = new Pesanan($conn);
$pesanans = $pesananModel->getByStatus($status);
?>
<?php include 'views/admin/header.php'; ?>
<?php include 'views/admin/navbar.php'; ?>


    <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
                     <h2>List Transaksi</h2>
                    </div>
                </div>
                 <!-- /. ROW  -->
                 <hr />
								 <div class="row">
		                 <div class="col-md-12">
		                     <!-- Advanced Tables -->
		                     <div class="panel panel-default">
		                         <div class="panel-heading">
		                              List Transaksi
		                         </div>
		                         <div class="panel-body">
                                    <div class="row">
                                        <div class="col-12" style="margin: 1rem">
                                            <ul class="nav nav-pills">
                                                <li role="presentation" class="<?= !in_array($status, ['Dibayar', 'Diproses', 'dibayar', 'diproses']) ? 'active' : ''?>"><a href="admin-listtransaksi.php">Menunggu Pembayaran</a></li>
                                                <li role="presentation" class="<?= strtolower($status) == 'dibayar' ? 'active' : '' ?>"><a href="admin-listtransaksi.php?status=dibayar">Dibayar</a></li>
                                                <li role="presentation" class="<?= strtolower($status) == 'diproses' ? 'active' : '' ?>"><a href="admin-listtransaksi.php?status=diproses">Diproses</a></li>
                                            </ul>
                                        </div>
                                    </div>
		                             <div class="table-responsive">
		                                 <table class="table table-striped table-bordered table-hover" id="dataTables-example">
		                                    <thead>
                                                <tr>
                                                    <th>
                                                        Nomor pesanan
                                                    </th>
                                                    <th>
                                                        Nama Penerima
                                                    </th>
                                                    <th>
                                                        Total Harga
                                                    </th>
                                                    <th>
                                                        Status Pesanan
                                                    </th>
                                                    <th>

                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($pesanans as $pesanan) {?>
                                                    <tr>
                                                        <td>
                                                            <?= $pesanan['nomor_pesanan']?>
                                                        </td>
                                                        <td>
                                                            <?= $pesanan['nama_penerima']?>
                                                        </td>
                                                        <td>
                                                            <?= $pesanan['total_harga']?>
                                                        </td>
                                                        <td>
                                                            <?= $pesanan['status_pesanan']?>
                                                        </td>
                                                        <td>
                                                            <div class="btn-group">
                                                                <a href="admin-transaksi.php?order-number=<?= $pesanan['nomor_pesanan'] ?>" class="btn btn-primary">View</a>
                                                                <a href="admin-listtransaksi.php?id=<?= $pesanan['id'] ?>" class="btn btn-danger delete" onclick="return ConfirmDelete()">Delete</a>
                                                            </div>    
                                                        </td>
                                                    </tr>
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

    const selectTab = (e) => {
        console.log(e);
    }

	function ConfirmDelete(){
		return confirm('Are you sure you want to delete?');

	}
</script>
