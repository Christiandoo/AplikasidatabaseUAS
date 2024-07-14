
<?php
include 'koneksi.php';

if(!isset($_SESSION['username'])){
	header('location:login.php');
}

use model\Pembayaran;
use model\Pesanan;
use model\PesansanItems;

include './model/PesananItems.php';
include './model/Pesanan.php';
include './model/Pembayaran.php';
include 'koneksi.php';

if(!isset($_GET['order-number'])) {
    header("Location: admin-listtransaksi.php");
}

$order_number = $_GET['order-number'];
$pesanan = new Pesanan($conn);

$pesananData = $pesanan->selectByOrderNumber($order_number);
if(!$pesananData) {
    header("Location: admin-listtransaksi.php");
}

$pembayaranModel = new Pembayaran($conn);
$pembayaran = $pembayaranModel->getPembayaran($pesananData['id']);
$pesananItem = new PesansanItems($conn);
$items = $pesananItem->getByIdPesanan($pesananData['id']);
?>
<?php include 'views/admin/header.php'; ?>
<?php include 'views/admin/navbar.php'; ?>


    <div id="page-wrapper" >
            <div id="page-inner">
                 <!-- /. ROW  -->
                 <hr />
                    <div class="row">
                        <div class="col-md-12">
                            <div class="panel panel-default">
                                <div class="panel-heading" style="display: flex;">
                                    Transaksi Detail
                                    <?php 
                                        if($pesananData['status_pesanan'] == 'Dibayar') { ?> 
                                            <span class="badge badge-font-weight" style="background-color:red; margin-left: auto; padding :0.5rem">Pembayaran Butuh Konfirmasi</span>
                                    <?php 
                                        }
                                    ?>
                                     <?php 
                                        if($pesananData['status_pesanan'] == 'Diproses') { ?> 
                                            <span class="badge badge-font-weight" style="background-color:blue; margin-left: auto; padding :0.5rem">Pesanan Diproses</span>
                                    <?php 
                                        }
                                    ?>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12 table-responsive p-4">
                                            <table style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 10%;">Nama : </th>
                                                        <th style="width: 90%;"><?= $pesananData['nama_penerima']?></th>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 10%;">Alamat : </th>
                                                        <th style="width: 90%;"><?= $pesananData['alamat']?></th>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 10%;">Kota : </th>
                                                        <th style="width: 90%;"><?= $pesananData['kota']?></th>
                                                    </tr>
                                                    <tr>
                                                        <th style="width: 10%;">Kode pos : </th>
                                                        <th><?= $pesananData['kode_pos']?></th>
                                                    </tr>
                                                </thead>
                                            </table>
                                            
                                            <table class="table table-stripped">
                                                <thead>
                                                    <tr>
                                                        <th style="padding: 1rem;">
                                                            #
                                                        </th>
                                                        <th style="padding: 1rem;">
                                                            Nama Produk
                                                        </th>
                                                        <th style="padding: 1rem;">
                                                            Harga Satuan
                                                        </th>
                                                        <th style="padding: 1rem;">
                                                            Jumlah
                                                        </th>
                                                        <th style="padding: 1rem;">
                                                            Total Harga
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        $no = 1;
                                                        $sub_total = 0;
                                                        foreach ($items as $item) { 
                                                        $sub_total += $item['harga'] * $item['qty'];
                                                    ?>
                                                            <tr>
                                                                <td style="padding: 1rem;">
                                                                    <?= $no++ ;?>
                                                                </td>
                                                                <td style="padding: 1rem;">
                                                                    <?= $item['nama_product'];?>
                                                                </td>
                                                                <td style="padding: 1rem;">
                                                                    <?= "Rp. " . number_format($item['harga'], 0,',','.')?>
                                                                </td>
                                                                <td style="padding: 1rem;">
                                                                    <?= $item['qty']?>
                                                                </td>
                                                                <td style="padding: 1rem;">
                                                                    ,<?= "Rp. " . number_format($item['harga'] * $item['qty'], 0, ',', '.')?>
                                                                </td>
                                                            </tr> 
                                                        <?php }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4">
                                                            Grand Total
                                                        </th>
                                                        <th>
                                                            <?= "Rp. " . number_format($sub_total, 0, ',', '.')?>
                                                        </th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <?php 
                                        if($pesananData['status_pesanan'] == 'Dibayar') { ?> 
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <button class="btn btn-success" data-toggle="modal" data-target="#myModal">Lihat Pembayaran</button>
                                                </div>
                                            </div>
                                    <?php 
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
		        </div>
                <!-- /. ROW  -->
                <!-- /. ROW  -->
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Konfirmasi Pembayaran</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="justify-content: center; display:flex">
            <div class="col-md-10" style="margin-bottom: 2rem;display: flex; gap: 1rem; flex-direction: column; justify-content:center; align-items:center">
                <div style="border: 1px solid black;border-radius: 8px;
                    height: 300px; width: 300px;
                    background-size: cover; 
                    background-position: center;
                    background-image: url('<?= $pembayaran['bukti_pembayaran']?>')
                "></div>
                <button class="btn btn-primary" id="konfirmasi">Konfirmasi Pembayaran</button>
            </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'views/admin/footer.php'; ?>
<script>
    $('document').ready(() => {
        $('#konfirmasi').on('click', () => {
            let nomor_pesanan = <?= json_encode($pesananData['nomor_pesanan']); ?>;
            console.log(nomor_pesanan);
            let fd = new FormData();
            fd.append('nomor_pesanan', nomor_pesanan);

            $.ajax({
                url: 'konfirmasi-pembayaran.php',
                method: "POST",
                processData: false,
                contentType: false,
                data: fd,
                success: (response) => {
                    $('#myModal').modal('hide');
                    location.reload();
                },
                error: (error) => {
                    alert(error.message)
                }
            })
        })
    })
	function ConfirmDelete(){
		return confirm('Are you sure you want to delete?');

	}
</script>
