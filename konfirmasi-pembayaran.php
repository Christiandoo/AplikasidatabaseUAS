<?php
include_once './koneksi.php';
include_once './model/Pembayaran.php';

use model\Pembayaran;
use model\Pesanan;

header('Content-Type: application/json'); // Set header untuk JSON response

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['nomor_pesanan'])) {
        $response = [
            'status' => 'error',
            'message' => 'Nomor pesanan tidak ditemukan.'
        ];
         echo json_encode($response);
         return;
    }
    $nomor_pesanan = $_POST['nomor_pesanan'];
    $pesananModel = new Pesanan($conn);
    $pesanan = $pesananModel->selectByOrderNumber($nomor_pesanan);
    $pesananModel->updateStatus($pesanan['id'], 'Diproses');

    if($pesananModel->error()) {
        $response = [
            'status'=> 'error',
            'message' => 'Gagal konfirmasi pesanan silahkan coba lagi',
        ];
    }

    $response = [
        'status' => 'Success',
        'message' => 'Berhasil konfirmasi pesanan',
    ];

} else {
    $response = [
        'status' => 'error',
        'message' => 'Metode permintaan tidak didukung.'
    ];
}

echo json_encode($response);
return;