<?php
include 'koneksi.php';

// Cek apakah sesi sudah dimulai
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // Arahkan pengguna ke halaman lain atau tampilkan pesan yang lebih ramah
    header('location:admin-listpost.php');
    exit;
}

$sqll = "SELECT * FROM post_produk WHERE id = $id";
$result = mysqli_query($conn, $sqll);

if (!$result) {
    // Tampilkan pesan kesalahan dengan lebih baik
    echo "<script>alert('Terjadi kesalahan dalam menjalankan query.');window.location.href='admin-listpost.php';</script>";
    exit;
}

$detail = mysqli_fetch_array($result, MYSQLI_ASSOC);

if (!$detail) {
    // Arahkan pengguna ke halaman lain atau tampilkan pesan yang lebih ramah
    echo "<script>alert('Detail produk tidak ditemukan.');window.location.href='admin-listpost.php';</script>";
    exit;
}

$sqlll = "SELECT * FROM kategori";
$resultt = mysqli_query($conn, $sqlll);

if (!$resultt) {
    // Tampilkan pesan kesalahan dengan lebih baik
    echo "<script>alert('Terjadi kesalahan dalam menjalankan query kategori.');window.location.href='admin-listpost.php';</script>";
    exit;
}

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $produk = $_POST['produk'];
    $foto = $_FILES['foto']['name'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $tgl_post = $_POST['tgl_post'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];

    if (!empty($foto)) {
        $target_dir = "upload/";
        $nama_file = basename($_FILES['foto']["name"]);
        $target_file = $target_dir . $nama_file;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $image_size = $_FILES["foto"]["size"];

        // Validasi file yang diunggah
        $uploadOk = 1;
        if ($image_size > 5000000) {
            echo "<script>alert('Ukuran file terlalu besar.');history.back(-1);</script>";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>alert('Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.');history.back(-1);</script>";
            $uploadOk = 0;
        }

        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
                $sql = "UPDATE post_produk SET produk = '$produk', foto = '$foto', deskripsi = '$deskripsi', harga = '$harga', tgl_post = '$tgl_post', kategori = '$kategori', stok = '$stok' WHERE id = $id";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('Berhasil Update Post');window.location.href='admin-listpost.php';</script>";
                } else {
                    echo "<script>alert('Gagal Update Post');history.back(-1);</script>";
                }
            } else {
                echo "<script>alert('Terjadi kesalahan saat mengunggah file.');history.back(-1);</script>";
            }
        }
    } else {
        $sql = "UPDATE post_produk SET produk = '$produk', deskripsi = '$deskripsi', harga = '$harga', tgl_post = '$tgl_post', kategori = '$kategori', stok = '$stok' WHERE id = $id";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Berhasil Update Post');window.location.href='admin-listpost.php';</script>";
        } else {
            echo "<script>alert('Gagal Update Post');history.back(-1);</script>";
        }
    }
}
?>

<?php include 'views/admin/header.php'; ?>
<?php include 'views/admin/navbar.php'; ?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>Post</h2>
                <h5>Silahkan Tambah Post Dibawah Ini.</h5>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tambah Post
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-9">
                                <form role="form" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Produk</label>
                                        <input class="form-control" name="produk" required autofocus value="<?=$detail['produk']?>"/>
                                        <input class="form-control" type="hidden" name="id" value="<?=$detail['id']?>"/>
                                    </div>
                                    <div class="form-group">
                                        <label>Upload Gambar Produk</label>
                                        <input type="file" name="foto">
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea required name="deskripsi" class="form-control" cols="8" rows="9"><?=$detail['deskripsi']?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Harga</label>
                                        <input type="text" class="form-control" name="harga" required value="<?=$detail['harga']?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Post</label>
                                        <input type="date" class="form-control" name="tgl_post" required value="<?=$detail['tgl_post']?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select class="form-control" name="kategori" required>
                                            <?php while ($row = $resultt->fetch_assoc()) { ?>
                                                <option value="<?=$row['nama_kategori']?>" <?=($detail['kategori'] == $row['nama_kategori']) ? 'selected' : '' ?>><?=$row['nama_kategori']?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Stok</label>
                                        <input type="text" class="form-control" name="stok" required value="<?=$detail['stok']?>">
                                    </div>
                                    <div class="form-group">
                                        <button type="reset" class="btn btn-primary" name="reset">Reset</button>
                                        <button type="submit" class="btn btn-success right" name="submit">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'views/admin/footer.php'; ?>