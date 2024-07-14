<?php
include 'koneksi.php';

// Mengambil ID postingan dari parameter URL dengan sanitasi input
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Query untuk mendapatkan detail postingan berdasarkan ID
$sqll = "SELECT * FROM post_produk WHERE id = $id";
$result = mysqli_query($conn, $sqll);
$detail = mysqli_fetch_array($result);

// Query untuk mendapatkan komentar yang terkait dengan postingan
$sql_komentar = "SELECT * FROM komentar WHERE id_post = $id";
$result_komentar = mysqli_query($conn, $sql_komentar);

// Proses penambahan komentar
if (isset($_POST['send_komentar'])) {
    // Mengambil data dari form dengan sanitasi input
    $id_post = $_POST['id_post'];
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']);
    // Mendapatkan tanggal posting komentar
    $tgl_post = date("Y-m-d");

    // Query untuk menyimpan komentar ke dalam database
    $sql = "INSERT INTO komentar (nama, email, komentar, tgl_komentar, id_post) VALUES ('$nama', '$email', '$komentar', '$tgl_post', '$id_post')";
    if (mysqli_query($conn, $sql)) {
        // Menampilkan pesan berhasil jika komentar berhasil ditambahkan
        echo "<script>alert('Berhasil Menambah Komentar');</script>";
    } else {
        echo "<script>alert('Gagal Menambah Komentar');</script>";
    }
}
?>

<?php include 'views/blog/header.php'; ?>

<!-- Bagian utama untuk menampilkan detail postingan dan komentar -->
<div id="white">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <!-- Menampilkan gambar produk -->
                <a class="zoom green" href="upload/<?=$detail['foto']?>"><img class="img-responsive" src="upload/<?=$detail['foto']?>" /></a>
                <!-- Menampilkan nama produk -->
                <h2><?=$detail['produk']?></h2>
                <!-- Menampilkan harga produk -->
                <p><?=$detail['harga']?></p>
                <!-- Menampilkan tanggal posting produk -->
                <p><bd><?=$detail['tgl_post']?></bd></p>
                <br>
                <!-- Menampilkan deskripsi produk -->
                <p><?=$detail['deskripsi']?></p>
                <br>
                <!-- Menampilkan stok produk -->
                <p><bt>TAGS: <?=$detail['stok']?></bt></p>
                <hr>
                <!-- Link untuk kembali ke halaman sebelumnya -->
                <p><a href="index.php"> (Back)</a></p>
                <hr>

                <!-- Looping untuk menampilkan setiap komentar yang terkait dengan postingan -->
                <?php while ($row = $result_komentar->fetch_assoc()) { ?>
                    <h4>Komentar</h4><br>
                    <!-- Menampilkan nama dan tanggal komentar -->
                    <h6><?=$row['nama']?> / <?=$row['tgl_komentar']?></h6>
                    <!-- Menampilkan isi komentar -->
                    <p><?=$row['komentar']?></p>
                <?php } ?>

                <hr>
                <h4>Tambah Komentar</h4><br>
                <!-- Form untuk menambah komentar baru -->
                <form method="post">
                    <div class="form-group">
                        <label>Nama</label>
                        <input class="form-control" name="nama" required>
                        <input class="form-control" type="hidden" name="id_post" value="<?=$detail['id']?>">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input class="form-control" name="email" type="email" required>
                    </div>
                    <div class="form-group">
                        <label>Pesan</label>
                        <textarea class="form-control" name="komentar" rows="8" cols="10" required></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" name="send_komentar">Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- /row -->
    </div> <!-- /container -->
</div><!-- /white -->

<?php include 'views/blog/footer.php'; ?>
