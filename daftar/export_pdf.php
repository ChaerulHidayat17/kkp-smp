<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../vendor/autoload.php';
include 'config.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Validasi ID
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("ID tidak valid!");
}

// Ambil data berdasarkan ID
$query = "SELECT * FROM peserta_didik WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data tidak ditemukan!");
}

// Konfigurasi Dompdf
$options = new Options();
$options->set('defaultFont', 'Arial');
$options->set('isHtml5ParserEnabled', true);
$options->set('isRemoteEnabled', true);
$dompdf = new Dompdf($options);

// Fungsi sanitasi data
function cleanData($value) {
    return htmlspecialchars($value ?? '-', ENT_QUOTES, 'UTF-8');
}

// HTML untuk PDF dengan tabel
$html = "
<!DOCTYPE html>
<html lang='id'>
<head>
    <meta charset='UTF-8'>
    <title>Detail Peserta Didik</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h2 { text-align: center; margin-bottom: 20px; }
        .container { max-width: 700px; margin: auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 10px; border: 1px solid #333; text-align: left; }
        th { background-color: #f2f2f2; font-weight: bold; }
        .label { font-weight: bold; }
    </style>
</head>
<body>
    <div class='container'>
        <h2>Detail Peserta Didik</h2>
        <table>
            <tr><th class='label'>Nama</th><td>" . cleanData($data['nama_lengkap']) . "</td></tr>
            <tr><th class='label'>Jenis Kelamin</th><td>" . cleanData($data['jenis_kelamin']) . "</td></tr>
            <tr><th class='label'>NISN</th><td>" . cleanData($data['nisn']) . "</td></tr>
            <tr><th class='label'>No. Seri Ijazah SD</th><td>" . cleanData($data['no_ijazah']) . "</td></tr>
            <tr><th class='label'>No. Ujian Nasional</th><td>" . cleanData($data['no_ujian']) . "</td></tr>
            <tr><th class='label'>No. Kartu Keluarga</th><td>" . cleanData($data['no_kk']) . "</td></tr>
            <tr><th class='label'>No. Induk Kependudukan</th><td>" . cleanData($data['nik']) . "</td></tr>
            <tr><th class='label'>Nama Sekolah Asal</th><td>" . cleanData($data['sekolah_asal']) . "</td></tr>
            <tr><th class='label'>Tempat Lahir</th><td>" . cleanData($data['tempat_lahir']) . "</td></tr>
            <tr><th class='label'>Tanggal Lahir</th><td>" . cleanData($data['tanggal_lahir']) . "</td></tr>
            <tr><th class='label'>Agama</th><td>" . cleanData($data['agama']) . "</td></tr>
            <tr><th class='label'>Alamat</th><td>" . cleanData($data['alamat'] . ', ' . $data['kelurahan'] . ', ' . $data['kecamatan'] . ', ' . $data['kabupaten'] . ', ' . $data['provinsi']) . "</td></tr>
            <tr><th class='label'>Alat Transportasi</th><td>" . cleanData($data['alat_transportasi']) . "</td></tr>
            <tr><th class='label'>No HP</th><td>" . cleanData($data['no_hp']) . "</td></tr>
            <tr><th class='label'>No KIP</th><td>" . cleanData($data['no_kip']) . "</td></tr>
            <tr><th class='label'>Nama Tertera di KIP</th><td>" . cleanData($data['nama_kip']) . "</td></tr>
        </table>
    </div>
</body>
</html>
";

// Load HTML ke Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Simpan PDF ke file sementara
$filePath = sys_get_temp_dir() . "/Detail_Peserta_Didik_{$data['id']}.pdf";
file_put_contents($filePath, $dompdf->output());

// Header untuk download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
header('Content-Length: ' . filesize($filePath));
readfile($filePath);

// Hapus file sementara setelah dikirim
unlink($filePath);

// Tutup koneksi database
$stmt->close();
$conn->close();
?>
