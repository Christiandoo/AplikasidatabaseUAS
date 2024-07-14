
<?php

use model\Pesanan;
use model\PesansanItems;

include './model/PesananItems.php';
include './model/Pesanan.php';
include 'koneksi.php';

if(!isset($_GET['order-number'])) {
    header("Location: index.php");
}

$order_number = $_GET['order-number'];
$pesanan = new Pesanan($conn);

$pesananData = $pesanan->selectByOrderNumber($order_number);
if(!$pesananData) {
    header("Location: index.php");
}
$pesananItem = new PesansanItems($conn);
$items = $pesananItem->getByIdPesanan($pesananData['id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invocie</title>
</head>
<body>
<div class="container" style="padding:  1rem;">
    <table style="width: 100%; border-collapse: collapse;">
        <tbody>
            <tr>
                <td colspan="2" style="display: flex; align-items:center; margin-bottom: 2rem;">
                    <h3>Transaksi Detail</h3>
                </td>
            </tr>
            <tr>
                <td style="width: 22%;"> <strong>Nomor Pesanan : </strong></th>
                <td style="width: 78%;"><?= strtoupper($pesananData['nomor_pesanan'])?></th>
            </tr>
            <tr>
                <td style="width: 22%;"><strong>Nama :</strong></td>
                <td style="width: 78%;"><?= $pesananData['nama_penerima']?></td>
            </tr>
            <tr>
                <td><strong>Alamat :</strong></td>
                <td><?= $pesananData['alamat']?></td>
            </tr>
            <tr>
                <td><strong>Kota :</strong></td>
                <td><?= $pesananData['kota']?></td>
            </tr>
            <tr>
                <td><strong>Kode pos :</strong></td>
                <td><?= $pesananData['kode_pos']?></td>
            </tr>
        </tbody>
    </table>

    <table style="margin-top: 16px; width: 100%; background: white; border-collapse: collapse;">
        <thead>
            <tr>
                <th style="padding: 1rem; border: 1px solid #000;">#</th>
                <th style="padding: 1rem; border: 1px solid #000;">Nama Produk</th>
                <th style="padding: 1rem; border: 1px solid #000;">Harga Satuan</th>
                <th style="padding: 1rem; border: 1px solid #000;">Jumlah</th>
                <th style="padding: 1rem; border: 1px solid #000;">Total Harga</th>
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
                    <td style="padding: 1rem; border: 1px solid #000;"><?= $no++ ?></td>
                    <td style="padding: 1rem; border: 1px solid #000;"><?= $item['nama_product'];?></td>
                    <td style="padding: 1rem; border: 1px solid #000;"><?= "Rp. " . number_format($item['harga'], 0,',','.')?></td>
                    <td style="padding: 1rem; border: 1px solid #000;"><?= $item['qty']?></td>
                    <td style="padding: 1rem; border: 1px solid #000;"><?= "Rp. " . number_format($item['harga'] * $item['qty'], 0, ',', '.')?></td>
                </tr>
            <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" style="text-align: right; padding: 1rem; border: 1px solid #000;">Grand Total</th>
                <th style="padding: 1rem; border: 1px solid #000;"><?= "Rp. " . number_format($sub_total, 0, ',', '.')?></th>
            </tr>
        </tfoot>
    </table>

    <?php if ($pesananData['status_pesanan'] ===  'Menunggu Pembayaran') { ?>
        <table style="margin-top: 16px; width: 100%; background: white; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="padding: 1rem; border: 1px solid #000; width: 10%;"><sup style="color: red"> * </sup> Silahkan lakukan pembayaran ke rekening :</td>
                    <td style="padding: 1rem; border: 1px solid #000;"><?= "BCA : 91019101910190, A/N siapa" ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="padding: 1rem; border: 1px solid #000;">Sudah membayar? <a href="#" data-toggle="modal" data-target="#myModal">Upload Pembayaran</a></td>
                </tr>
            </tbody>
        </table>
    <?php } else { ?>
        <table style="margin-top: 16px; width: 100%; background: white; border-collapse: collapse;">
            <tbody>
                <tr>
                    <td style="padding: 1rem; border: 1px solid #000; background-color: green; padding: 0.5rem; border-radius: 5px;">Pesanan Sudah Dibayar</td>
                </tr>
            </tbody>
        </table>
    <?php } ?>
</div>

</body>
</html>