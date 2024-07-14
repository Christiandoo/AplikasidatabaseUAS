<?php
// Sertakan autoloader dari DOMPDF
require_once 'dompdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Set opsi untuk DOMPDF
$options = new Options();
$options->set('defaultFont', 'Courier');

// Buat instance DOMPDF baru
$dompdf = new Dompdf($options);

// Aktifkan output buffering
ob_start();

// Sertakan file PHP yang memuat konten HTML
include('template-pdf.php');

// Ambil konten dari buffer dan simpan ke variabel
$html = ob_get_clean();

// Muat konten HTML ke dalam DOMPDF
$dompdf->loadHtml($html);

// Atur ukuran dan orientasi kertas
$dompdf->setPaper('A4', 'portrait');

// Render PDF (konversi HTML ke PDF)
$dompdf->render();

// Simpan file PDF ke dalam server (opsional)
$pdfOutput = $dompdf->output();
$pdfFilePath = 'invoice.pdf';
file_put_contents($pdfFilePath, $pdfOutput);

// Atur header untuk memaksa unduhan
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="invoice.pdf"');
header('Content-Length: ' . filesize($pdfFilePath));

// Output file PDF ke output buffer
readfile($pdfFilePath);
?>
