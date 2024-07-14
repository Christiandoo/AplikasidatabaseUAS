<?php
require_once('./model/Pesanan.php');
use model\Cart;
use model\Pesanan;

include 'koneksi.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$userId = $_SESSION['id'];
if(!$userId) {
    header('Location:login.php');
}

$pesananModel = new Pesanan($conn, $userId);
$pesanans = $pesananModel->getByUserId();

?>

<?php include 'views/blog/header.php'; ?>
<!-- +++++ Keranjang Section +++++ -->
<div class="container">
    <h2>History Pesanan</h2>

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
<?php
  if(isset($pesanans)) { 
    foreach($pesanans as $pesanan) {
        ?>

    
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
  <?php }
  }
?>
                                                  </tbody>
                                               </table>
      </div>
      </div>

</div>


</div>
<?php include 'views/blog/footer.php'; ?>