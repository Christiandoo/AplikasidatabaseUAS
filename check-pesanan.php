<?php
require_once('./model/Pesanan.php');
use model\Cart;
use model\Pesanan;

include 'koneksi.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$session_id = session_id();

if(isset($_GET['order-number'])) {
    $order_number = $_GET['order-number'];

    $modelPesanan = new Pesanan($conn);
    $pesanan = $modelPesanan->selectByOrderNumber($order_number);
}

?>

<?php include 'views/blog/header.php'; ?>
<!-- +++++ Keranjang Section +++++ -->
<div class="container">
    <h2>Check Pesanan</h2>

<div class="row">
<div class="col-12" style="padding: 1rem; margin-top: 1rem">
    <form action="" method="get">
        <input type="text" class="form-control" name="order-number" placeholder="Masukan nomor order disini">
        <button class="btn btn-primary" type="submit" style="margin: 1rem 0 1rem 0">Cari pesanan</button>
    </form>
</div>
<?php
  if(isset($pesanan)) { ?>
      <div class="col-12">
      <div class="table-responsive">
      <table class="table table-striped table-bordered" id="dataTables-example">
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
                                                      </tr>
                                                  </thead>
                                                  <tbody>
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
                                                          </tr>
                                                  </tbody>
                                               </table>
      </div>
      </div>

  <?php }
?>
</div>


</div>
<?php include 'views/blog/footer.php'; ?>