<?php
session_start(); // Mulai session

include 'koneksi.php'; // Koneksi ke database

// Pastikan pengguna sudah login
if(!isset($_SESSION['username'])){
	header('Location: login.php');
	exit;
}

// Ambil data produk dari database
$sql = "SELECT * FROM post_produk";
$result = mysqli_query($conn, $sql);

// Hapus produk jika ada parameter id
if(isset($_GET['id'])){
	$id = $_GET['id'];

	// Validasi ID
	if (is_numeric($id)) {
		$sql = "DELETE FROM post_produk WHERE id = ?";
		$stmt = mysqli_prepare($conn, $sql);
		mysqli_stmt_bind_param($stmt, 'i', $id);
		if(mysqli_stmt_execute($stmt)){
			echo "<script>window.location.href='admin-listpost.php';</script>";
			exit;
		} else {
			echo "<script>alert('Gagal menghapus produk');</script>";
		}
	} else {
		echo "<script>alert('ID tidak valid');</script>";
	}
}
?>
<?php include 'views/admin/header.php'; ?>
<?php include 'views/admin/navbar.php'; ?>

<div id="page-wrapper">
    <div id="page-inner">
        <div class="row">
            <div class="col-md-12">
                <h2>List Produk</h2>
                <h5>List Semua Produk</h5>
            </div>
        </div>
        <hr />
        <div class="row">
            <div class="col-md-12">
                <!-- Advanced Tables -->
                <div class="panel panel-default">
                    <div class="panel-heading">
                        List Post
                    </div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Produk</th>
                                        <th>Gambar Produk</th>
                                        <th>Deskripsi</th>
                                        <th>Harga</th>
                                        <th>Stok</th>
                                        <th>Edit Produk</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <tr class="odd gradeX">
                                            <td><?= $no ?></td>
                                            <td><?= $row['produk'] ?></td>
                                            <td><img src="upload/<?= $row['foto'] ?>" width="50px" height="50px"></td>
                                            <td><?= substr($row['deskripsi'], 0, 50) ?></td>
                                            <td><?= $row['harga'] ?></td>
                                            <td><?= $row['stok'] ?></td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="admin-editpost.php?id=<?= $row['id'] ?>" class="btn btn-warning">Edit</a>
                                                    <a href="admin-listpost.php?id=<?= $row['id'] ?>" class="btn btn-danger delete" onclick="return ConfirmDelete()">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php $no++; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--End Advanced Tables -->
            </div>
        </div>
    </div>
</div>

<?php include 'views/admin/footer.php'; ?>

<script>
    function ConfirmDelete() {
        return confirm('Are you sure you want to delete?');
    }
</script