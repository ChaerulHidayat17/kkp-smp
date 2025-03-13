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
    die("ID tidak valid! Silakan periksa kembali.");
}

// Cek ID dalam database
$query_check = "SELECT COUNT(*) as count FROM peserta_didik WHERE id = ?";
$stmt_check = $conn->prepare($query_check);
$stmt_check->bind_param("i", $id);
$stmt_check->execute();
$result_check = $stmt_check->get_result();
$row_check = $result_check->fetch_assoc();

if ($row_check['count'] == 0) {
    die("Data dengan ID: $id tidak ditemukan! Periksa kembali.");
}

// Ambil data peserta didik
$query = "SELECT * FROM peserta_didik WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Data peserta didik tidak ditemukan!");
}

// Ambil data orang tua
$query_ortu = "SELECT * FROM orang_tua WHERE peserta_id = ?";
$stmt_ortu = $conn->prepare($query_ortu);
$stmt_ortu->bind_param("i", $id);
$stmt_ortu->execute();
$result_ortu = $stmt_ortu->get_result();
$data_ortu = $result_ortu->fetch_assoc();

// Ambil data wali
$query_wali = "SELECT * FROM wali WHERE peserta_id = ?";
$stmt_wali = $conn->prepare($query_wali);
$stmt_wali->bind_param("i", $id);
$stmt_wali->execute();
$result_wali = $stmt_wali->get_result();
$data_wali = $result_wali->fetch_assoc();

// Ambil data dari periodik
$query_periodik = "SELECT * FROM data_periodik WHERE peserta_id = ?";
$stmt_periodik = $conn->prepare($query_periodik);
$stmt_periodik->bind_param("i", $id);
$stmt_periodik->execute();
$result_periodik = $stmt_periodik->get_result();
$data_periodik = $result_periodik->fetch_assoc();

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

// **Halaman 1 - Data Peserta Didik**
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
        .page-break { page-break-before: always; }
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
        </table>
    </div>

    <div class='page-break'></div>

    <div class='container'>
        <h2>Data Orang Tua</h2>
        <table>
            <tr><th class='label'>Nama Ayah</th><td>" . cleanData($data_ortu['nama_ayah'] ?? '-') . "</td></tr>
            <tr><th class='label'>Nik  Ayah</th><td>" . cleanData($data_ortu['nik_ayah'] ?? '-') . "</td></tr>
            <tr><th class='label'>Tahun Lahir Ayah</th><td>" . cleanData($data_ortu['tahun_lahir_ayah'] ?? '-') . "</td></tr>
            <tr><th class='label'>Pekerjaan Ayah</th><td>" . cleanData($data_ortu['pekerjaan_ayah'] ?? '-') . "</td></tr>
            <tr><th class='label'>Pendidikan Terakhir Ayah</th><td>" . cleanData($data_ortu['pendidikan_ayah'] ?? '-') . "</td></tr>
            <tr><th class='label'>Penghasilan Bulanan Ayah</th><td>" . cleanData($data_ortu['penghasilan_ayah'] ?? '-') . "</td></tr>
            <tr><th class='label'>Nama Ibu</th><td>" . cleanData($data_ortu['nama_ibu'] ?? '-') . "</td></tr>
            <tr><th class='label'>Nik  Ibu</th><td>" . cleanData($data_ortu['nik_ibu'] ?? '-') . "</td></tr>
            <tr><th class='label'>Tahun Lahir Ibu</th><td>" . cleanData($data_ortu['tahun_lahir_ibu'] ?? '-') . "</td></tr>
            <tr><th class='label'>Pekerjaan Ibu</th><td>" . cleanData($data_ortu['pekerjaan_ibu'] ?? '-') . "</td></tr>
            <tr><th class='label'>Pendidikan Terakhir Ibu</th><td>" . cleanData($data_ortu['pendidikan_ibu'] ?? '-') . "</td></tr>
            <tr><th class='label'>Penghasilan Bulanan Ibu</th><td>" . cleanData($data_ortu['penghasilan_ibu'] ?? '-') . "</td></tr>
        </table>
    </div>

    <div class='page-break'></div>

    <div class='container'>
        <h2>Data Wali</h2>
        <table>
            <tr><th class='label'>Nama Wali</th><td>" . cleanData($data_wali['nama_wali'] ?? '-') . "</td></tr>
            <tr><th class='label'>NIK Wali</th><td>" . cleanData($data_wali['nik_wali'] ?? '-') . "</td></tr>
            <tr><th class='label'>Pekerjaan Wali</th><td>" . cleanData($data_wali['pekerjaan_wali'] ?? '-') . "</td></tr>
            <tr><th class='label'>Pendidikan Wali</th><td>" . cleanData($data_wali['pendidikan_wali'] ?? '-') . "</td></tr>
            <tr><th class='label'>Penghasilan Wali</th><td>" . cleanData($data_wali['penghasilan_wali'] ?? '-') . "</td></tr>
        </table>
    </div>

    <div class='page-break'></div>
    
     <div class='container'>
        <h2>Data Periodik</h2>
        <table>
            <tr><th>Tinggi Badan</th><td>" . cleanData($data_periodik['tinggi_badan'] ?? '-') . " cm</td></tr>
            <tr><th>Berat Badan</th><td>" . cleanData($data_periodik['berat_badan'] ?? '-') . " kg</td></tr>
            <tr><th>Jarak Tempuh</th><td>" . cleanData($data_periodik['jarak_tempuh_km'] ?? '-') . " km</td></tr>
            <tr><th>Waktu Tempuh</th><td>" . cleanData($data_periodik['waktu_tempuh_menit'] ?? '-') . " menit</td></tr>
            <tr><th>Hobi</th><td>" . cleanData($data_periodik['hobi'] ?? '-') . "</td></tr>
            <tr><th>Cita Cita</th><td>" . cleanData($data_periodik['cita_cita'] ?? '-') . "</td></tr>
            <tr><th>Cita Cita</th><td>" . cleanData($data_periodik['jumlah_saudara_kandung'] ?? '-') . "</td></tr>
        </table>
    </div>
</body>
</html>
";

// Load HTML ke Dompdf
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("Detail_Peserta_Didik_$id.pdf", ["Attachment" => true]);

$stmt->close();
$stmt_check->close();
$stmt_ortu->close();
$stmt_wali->close();
$conn->close();
?>
