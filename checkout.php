<?php
// Include file koneksi database
include_once './model/Cart.php';
include_once './model/Pesanan.php';
include_once './model/Pembayaran.php';
include_once './model/PesananItems.php';

use model\Cart;
use model\Pemabayaran;
use model\Pembayaran;
use model\Pesanan;
use model\PesansanItems;
use model\Pesnana;

include 'koneksi.php';

// Mulai sesi jika belum dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION['id'];
if(!$userId) {
    header('Location:login.php');
}

// Ambil data dari keranjang belanja
$session_id = session_id();
$cart = new Cart($conn, $userId);
$prouct_in_cart = $cart->get();
$total_harga = 0;
foreach($prouct_in_cart as $product) {
    $total_harga += ($product['jumlah'] * $product['harga']);
}

// Jika tombol checkout diklik
if(isset($_POST['checkout'])) {
    // Ambil data alamat dan pembayaran dari form
    $nama_penerima = $_POST['nama_penerima'];
    $alamat = $_POST['alamat'];
    $kota = $_POST['kota'];
    $kode_pos = $_POST['kode_pos'];
    $metode_pembayaran = $_POST['metode_pembayaran'];
    // $nomor_kartu = $_POST['nomor_kartu'];

    $pesanan = new Pesanan($conn, $userId);
    $pesanan->store($total_harga, $nama_penerima, $alamat, $kode_pos, $kota);
    $id_pesanan = $pesanan->getIdPesanan();
    $pesananData = $pesanan->selectBy($id_pesanan);

    // $query_insert_pesanan = "INSERT INTO pesanan (total_harga, session_id, nama_penerima, alamat, kota, kode_pos) 
    //                          VALUES ($total_harga, '$session_id', '$nama_penerima', '$alamat', '$kota', '$kode_pos')";
    // $result_insert_pesanan = mysqli_query($conn, $query_insert_pesanan);
    // $id_pesanan = mysqli_insert_id($conn);

    if(!$pesanan->error()) {
        // Simpan data pembayaran ke dalam tabel pembayaran
        // $query_insert_pembayaran = "INSERT INTO pembayaran (id_pesanan, metode_pembayaran, nomor_kartu) 
        //                             VALUES ($id_pesanan, '$metode_pembayaran', '$nomor_kartu')";
        // $result_insert_pembayaran = mysqli_query($conn, $query_insert_pembayaran);

        $pembayaran = new Pembayaran($conn, $userId);
        $pembayaran->store($id_pesanan, $metode_pembayaran);
        
        if(!$pembayaran->error()) {
            $pesananItems = new PesansanItems($conn);
            $pesananItems->StorePesananItems($id_pesanan, $prouct_in_cart);
        }
    

        if($pesananItems->error()) {
            echo $pesananItems->errorMessage();
        }

        if(!$pembayaran->error()) {
            // Hapus keranjang belanja setelah berhasil checkout
            $query_hapus_keranjang = "DELETE FROM keranjang WHERE session_id = '$session_id'";
            $result_hapus_keranjang = mysqli_query($conn, $query_hapus_keranjang);
            
            if($result_hapus_keranjang) {
                // Redirect ke halaman sukses_checkout.php setelah berhasil checkout
                header("Location: invoice.php?order-number=".$pesananData['nomor_pesanan']);
                exit();
            } else {
                echo "Error: " . mysqli_error($conn);
                // Handle error
            }
        } else {
            echo "Error: " . mysqli_error($conn);
            // Handle error
        }
    } else {
        echo "Error: " . mysqli_error($conn);
        // Handle error
    }
}
?>

<?php include 'views/blog/header.php'; ?>
<!-- +++++ Form Checkout +++++ -->
<div class="container">
    <h2>Checkout</h2>
    <form method="post" action="">
        <div class="form-group">
            <label for="nama_penerima">Nama Penerima:</label>
            <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" required>
        </div>
        <div class="form-group">
            <label for="alamat">Alamat Pengiriman:</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="kota">Kota:</label>
            <input type="text" class="form-control" id="kota" name="kota" required>
        </div>
        <div class="form-group">
            <label for="kode_pos">Kode Pos:</label>
            <input type="text" class="form-control" id="kode_pos" name="kode_pos" required>
        </div>
        <div class="form-group">
            <label for="metode_pembayaran">Metode Pembayaran:</label>
            <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" required>
                <option value="transfer_bank">Transfer Bank</option>
                <!-- <option value="kartu_kredit">Kartu Kredit</option> -->
            </select>
        </div>
        <!-- <div class="form-group">
            <label for="nomor_kartu">Nomor Kartu:</label>
            <input type="text" class="form-control" id="nomor_kartu" name="nomor_kartu" required>
        </div> -->
        <button type="submit" class="btn btn-primary" name="checkout">Checkout</button>
    </form>
</div>
<?php include 'views/blog/footer.php'; ?>