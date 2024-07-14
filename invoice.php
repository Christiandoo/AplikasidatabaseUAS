<?php

use model\Pesanan;
use model\PesansanItems;

include './model/PesananItems.php';
include './model/Pesanan.php';
include 'koneksi.php';

if(!isset($_GET['order-number'])) {
    header("Location: index.php");
}

$userId = $_SESSION['id'];
if(!$userId) {
    header('Location:login.php');
}


$order_number = $_GET['order-number'];
$pesanan = new Pesanan($conn, $userId);

$pesananData = $pesanan->selectByOrderNumber($order_number);
if(!$pesananData) {
    header("Location: index.php");
}
$pesananItem = new PesansanItems($conn);
$items = $pesananItem->getByIdPesanan($pesananData['id']);
?>
<?php include 'views/blog/header.php'; 

?>
<div class="container" style="padding:  1rem;">
    <div class="row">
        <div class="col-12" style="display: flex; align-items:center; margin-bottom: 2rem">
            <h3>
                Transaksi Detail
            </h3>
            <a href="generate-pdf.php?order-number=<?=$pesananData['nomor_pesanan']?>" type="button" class="btn btn-primary" style="margin-left: auto;">Download Invoice</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12" style="min-height: 100vh">
            <div class="row">
                <div class="col-12">
                    <table style="background-color: white; width:100%">
                        <thead>
                            <tr>
                                <th style="width:10%">Nomor Pesanan : </th>
                                <th><?= strtoupper($pesananData['nomor_pesanan'])?></th>
                            </tr>
                            <tr>
                                <th style="width: 10%;">Nama : </th>
                                <th><?= $pesananData['nama_penerima']?></th>
                            </tr>
                            <tr>
                                <th style="width: 10%;">Alamat : </th>
                                <th><?= $pesananData['alamat']?></th>
                            </tr>
                            <tr>
                                <th style="width: 10%;">Kota : </th>
                                <th><?= $pesananData['kota']?></th>
                            </tr>
                            <tr>
                                <th style="width: 10%;">Kode pos : </th>
                                <th><?= $pesananData['kode_pos']?></th>
                            </tr>
                        </thead>
                    </table>
                    
                    <table class="table table" style="margin-top: 16px; background: white;">
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
                
                
                <?php if ($pesananData['status_pesanan'] ===  'Menunggu Pembayaran') { ?>
                    <div class="col-12">
                    <span> <sup style="color: red"> * </sup> Silahkan lakukan pembayaran ke rekening : <br></span>
                    <span>
                        BCA : 91019101910190, A/N siapa
                    </span>
                </div>
                    <div class="col-12" style="margin-top: 2rem;">
                        <span>Sudah membayar? <a href="#" data-toggle="modal" data-target="#myModal">Upload Pembayaran</a>
                    </div>
                <?php } else { ?>
                
                <div class="col-12" style="margin-top: 2rem;">
                    <span class="badge" style="background-color: green">Pesanan Sudah Dibayar</span>
                </div>

                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Upload Pembayaran</h4>
      </div>
      <div class="modal-body">
        <div class="row" style="display: flex; justify-content: center">
            <div id="image-preview" style="border: 1px solid black;border-radius: 8px; height: 300px; width: 300px; background-size: cover; background-position: center;"></div>
        </div>
        <div class="row" style="display: flex; justify-content:center; margin-top: 2rem">
            <div class="col-10">
                <div class="form-group">
                    <label for="">Pilih file</label>
                    <input type="file" class="form-control" id="fileInput" name="bukti_pembayaran" style="width: 100%;" accept=".jpg, .jpeg" required>
                </div>
            </div>
        </div>
        <div id="loading-state" style="height: 100%; width: 100%; background-color: black; position:absolute; top: 0; left: 0; opacity: 0.5;
            justify-content:center;
            display: flex;
            align-items:Center;
            flex-direction:column;
            display: none;
        ">
            <div class="loader" style="margin-bottom: 1rem;"></div>
            <p style="color: white">Uploading</p>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="upload">Upload</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function() {
        $('#fileInput').on('change', function() {
            var file = this.files[0];
            var imagePreview = $('#image-preview');
            
            if (file) {
                var fileType = file.type;
                var validImageTypes = ['image/jpeg', 'image/png'];
                
                if (validImageTypes.includes(fileType)) {
                    var reader = new FileReader();
                    
                    reader.onload = function(e) {
                        imagePreview.css('background-image', 'url(' + e.target.result + ')');
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    alert('Hanya file JPG yang diperbolehkan.');
                    $(this).val(''); // Reset input file
                    imagePreview.css('background-image', 'none');
                }
            } else {
                imagePreview.css('background-image', 'none');
            }
        });

        $('#upload').on('click', function(e) {
            e.preventDefault();
            var fileInput = $('#fileInput')[0];
            if (fileInput.files.length === 0) {
                alert('Pilih file terlebih dahulu.');
                return;
            }

            $('#loading-state').css('display', 'flex');
            var formData = new FormData();
            formData.append('bukti_pembayaran', fileInput.files[0]);
            formData.append('id_pesanan', <?= $pesananData['id']?>)

            $.ajax({
                url: 'upload-pembayaran.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    alert('File berhasil diunggah.');
                    $('#myModal').modal('hide');                    
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert('Gagal mengunggah file.');
                    console.error(textStatus, errorThrown);
                },
                complete: () => {
                    $('#loading-state').hide();
                }
            });
        });
    });
</script>

<?php include 'views/blog/footer.php'; ?>