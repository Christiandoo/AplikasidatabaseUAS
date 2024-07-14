<?php

include_once './koneksi.php';
include_once './model/Pembayaran.php';

use model\Pembayaran;
$userId = $_SESSION['id'];
if(!$userId) {
    header('Location:login.php');
}


header('Content-Type: application/json'); // Set header untuk JSON response

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['bukti_pembayaran']) && isset($_POST['id_pesanan'])) {
        $id_pesanan = $_POST['id_pesanan'];

        $fileTmpPath = $_FILES['bukti_pembayaran']['tmp_name'];
        $fileName = $_FILES['bukti_pembayaran']['name'];
        $fileSize = $_FILES['bukti_pembayaran']['size'];
        $fileType = $_FILES['bukti_pembayaran']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Ganti nama file jika diperlukan
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Tentukan direktori upload
            $uploadFileDir = './upload/bukti-pembayaran/';
            $dest_path = $uploadFileDir . $newFileName;

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true); // Buat direktori jika belum ada
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $pembayaran = new Pembayaran($conn,$userId);
                $pembayaran->update($id_pesanan, $dest_path);

                if (!$pembayaran->error()) {
                    $response = [
                        'status' => 'success',
                        'message' => 'File berhasil diunggah.',
                        'file_path' => $dest_path
                    ];
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => $pembayaran->errorMessage()
                    ];
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Ada kesalahan saat memindahkan file yang diunggah.'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Upload gagal. Hanya file dengan ekstensi JPG atau JPEG yang diperbolehkan.'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Ada kesalahan dalam pengunggahan file. Silakan coba lagi.'
        ];
    }
} else {
    $response = [
        'status' => 'error',
        'message' => 'Metode permintaan tidak didukung.'
    ];
}

echo json_encode($response);
?>
