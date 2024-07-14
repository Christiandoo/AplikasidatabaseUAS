<?php
require_once './model/Cart.php';
use model\Cart;

include 'koneksi.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userId = $_SESSION['id'];
if(!$userId) {
    header('Location:login.php');
}

$sql = "SELECT post_produk.*, keranjang.jumlah FROM keranjang 
        JOIN post_produk ON keranjang.id_produk = post_produk.id 
        WHERE keranjang.user_id = '$userId'";
$result = mysqli_query($conn, $sql);


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['increase']) && isset($_POST['produk_id'])) {
        $cartModel = new Cart($conn, $userId, $_POST['produk_id']);
        $cartModel->update();
        unset($_POST['produk_id']);
    }

    if (isset($_POST['decrease']) && isset($_POST['produk_id'])) {
        $cartModel = new Cart($conn, $userId, $_POST['produk_id']);
        $cartModel->decrease();
        unset($_POST['produk_id']);
    }

    // Redirect to the same page to clear POST data
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<?php include 'views/blog/header.php'; ?>
<!-- +++++ Keranjang Section +++++ -->
<div class="container">
    <h2>Keranjang Belanja</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['produk']) ?></td>
                    <td>Rp. <?= number_format($row['harga'], 0, ',', '.') ?></td>
                    <td>
                        <div style="display :flex; gap: 1rem; align-items:center; justify-content: center">
                            <form action="keranjang.php" method="post">
                                <input type="hidden" name="produk_id" value="<?= $row['id']; ?>">
                                <button class="btn btn-primary" type="submit" name="increase">+</button> 
                            </form>
                                <p style="font-size: large; margin: 0">
                                    <?= $row['jumlah'] ?>
                                </p>
                            <form action="keranjang.php" method="post">
                                <input type="hidden" name="produk_id" value="<?= $row['id']; ?>">
                                <button class="btn btn-danger" type="submit" name="decrease">-</button> 
                            </form>
                        </div>
                    
                    </td>
                    <td>Rp. <?= number_format($row['harga'] * $row['jumlah'], 0, ',', '.') ?></td>
                    <td><a href="hapus_keranjang.php?id=<?= $row['id'] ?>" class="btn btn-danger">Hapus</a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <a href="checkout.php" class="btn btn-success">Checkout</a>
</div>
<?php include 'views/blog/footer.php'; ?>