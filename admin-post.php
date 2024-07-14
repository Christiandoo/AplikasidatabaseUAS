<?php
include 'koneksi.php';

if(!isset($_SESSION['username'])){
    header('location:login.php');
}

if(isset($_POST['submit'])){
    
    $produk = $_POST['produk'];
    $foto = $_FILES['foto']['name'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $tgl_post = $_POST['tgl_post'];
    $kategori = $_POST['kategori'];
    $stok = $_POST['stok'];

    $target_dir = "upload/";
    $nama_file = basename($_FILES['foto']["name"]);
    $target_file = $target_dir . $nama_file;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $image_size = $_FILES["foto"]["size"];

    // Validasi file yang diunggah
    $uploadOk = 1;
    if($image_size > 5000000) {
        echo "<script>alert('Ukuran file terlalu besar.');history.back(-1);</script>";
        $uploadOk = 0;
    }

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        echo "<script>alert('Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan.');history.back(-1);</script>";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "<script>alert('Gagal mengunggah file.');history.back(-1);</script>";
    } else {
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO post_produk VALUES('', '$produk', '$foto', '$deskripsi', '$harga', '$tgl_post', '$kategori', '$stok')";
            if(mysqli_query($conn, $sql)){
                echo "<script>alert('Berhasil Menambah produk');window.location.href='admin-editpost.php';</script>";
            } else {
                echo "<script>alert('Gagal Menambah produk');history.back(-1);</script>";
            }
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah file.');history.back(-1);</script>";
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
                <h2>Tambah produk</h2>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tambah Produk
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-9">
                                <form role="form" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Nama Produk</label>
                                        <input class="form-control" name="produk" required autofocus />
                                    </div>
                                    <div class="form-group">
                                        <label>Upload Gambar produk</label>
                                        <input type="file" name="foto" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Deskripsi</label>
                                        <textarea required name="deskripsi" class="form-control" cols="8" rows="9"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>Harga</label>
                                        <input type="text" class="form-control" name="harga" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Tanggal Post Produk</label>
                                        <input type="date" class="form-control" name="tgl_post" required>
                                    </div>
                                    <div class="form-group">
                                        <label>Kategori</label>
                                        <select class="form-control" name="kategori" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="T-Shirt">T-Shirt</option>
                                            <option value="Long T-shirt">Long T-shirt</option>
                                            <option value="Hoodie">Hoodie</option>
                                            <option value="Kemeja">Kemeja</option>
                                            <option value="Celana Jeans">Celana Jeans</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Stok</label>
                                        <input type="text" class="form-control" name="stok" required >
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