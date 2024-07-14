<?php
include_once './model/Cart.php';
use model\Cart;

session_start(); // Pastikan sesi sudah dimulai

include 'koneksi.php';
include 'function_pengunjung.php';

$ip = ip_user();
$browser = browser_user();
$os = os_user();

if (!isset($_COOKIE['VISITOR'])) {
    $duration = time() + 60 * 60 * 24;

    setcookie('VISITOR', $browser, $duration);
    $dateTime = date('Y-m-d H:i:s');
    $page = basename($_SERVER['REQUEST_URI']);

    $sql = "INSERT INTO visitor (ip, os, browser, tgl_visitor, page) VALUES ('$ip', '$os', '$browser', '$dateTime', '$page')";
    mysqli_query($conn, $sql);
}

$nama = isset($_GET['nama']) ? $_GET['nama'] : '';
$sqll = "SELECT * FROM post_produk";
if ($nama) {
    $sqll .= " WHERE produk LIKE '%$nama%'";
}
$result = mysqli_query($conn, $sqll);

if (isset($_POST['add_to_cart'])) {
    $userId = $_SESSION['id'];
    if(!$userId) {
        header('Location:login.php');
    }

    $id_produk = $_POST['id_produk'];
    $session_id = session_id();

    $cart = new Cart($conn,$userId, $id_produk);

    $cart->addOrUpdate();
    if($cart->error()) {
        $message = $cart->errorMessage();
        echo "<script>alert('$message');</script>";
    }
    echo "<script>alert('Produk telah ditambahkan ke keranjang');</script>";
}
?>

<?php include 'views/blog/header.php'; ?>
<!-- +++++ Welcome Section +++++ -->
<!-- +++++ Projects Section +++++ -->
<div class="container">
    <div class="row">
        <form class="p-2" method="GET" action="">
            <div class="d-flex" style="gap: 1rem">
                <input type="text" name="nama" class="form-control" placeholder="Cari produk..." value="<?= htmlspecialchars($nama) ?>">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>
        <div class="row">
            <div class="col-12 text-end">
                <a class="btn btn-link" href="index.php">Show all</a>
            </div>
        </div>
        <div class="col-lg-13"></div>

        <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="col-md-4">
                <a class="zoom green" href="upload/<?= $row['foto'] ?>"><a href="readpost.php?id=<?= $row['id'] ?>">
                    <img class="img-responsive" src="upload/<?= $row['foto'] ?>" />
                </a>
                <div class="card-body">
                    <h3 class="card-title"><a href="readpost.php?id=<?= $row['id'] ?>"><?= htmlspecialchars($row['produk']) ?></a></h3>
                    <p class="card-text">Rp. <?= number_format($row['harga'], 0, ',', '.') ?></p>
                    <small class="text-muted"><?= htmlspecialchars($row['tgl_post']) ?></small>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="btn-group">
                            
                            <form method="POST" action="">
                                <input type="hidden" name="id_produk" value="<?= $row['id'] ?>">
                                <button type="submit" class="btn btn-primary" name="add_to_cart">Tambah ke keranjang</button>
                            </form>
                        </div>
                        
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div><!-- /container -->
<?php include 'views/blog/footer.php'; ?>