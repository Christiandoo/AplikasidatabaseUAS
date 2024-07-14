<?php
include 'koneksi.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id'])) {
    $id_produk = $_GET['id'];
    $session_id = session_id();

    $sql = "DELETE FROM keranjang WHERE id_produk = '$id_produk' AND session_id = '$session_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Produk telah dihapus dari keranjang'); window.location='keranjang.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus produk dari keranjang'); window.location='keranjang.php';</script>";
    }
}
?>