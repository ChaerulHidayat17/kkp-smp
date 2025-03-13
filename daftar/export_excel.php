<?php
require __DIR__ . '/../vendor/autoload.php';
include 'config.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Cell\DataType;

// Koneksi database
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query JOIN untuk mengambil data peserta didik, orang tua, wali, dan data periodik
$sql = "SELECT pd.*, 
        COALESCE(ot.nama_ayah, '') AS nama_ayah, COALESCE(ot.tahun_lahir_ayah, '') AS tahun_lahir_ayah, COALESCE(ot.nik_ayah, '') AS nik_ayah,
        COALESCE(ot.pekerjaan_ayah, '') AS pekerjaan_ayah, COALESCE(ot.pendidikan_ayah, '') AS pendidikan_ayah, COALESCE(ot.penghasilan_ayah, '') AS penghasilan_ayah,
        COALESCE(ot.nama_ibu, '') AS nama_ibu, COALESCE(ot.tahun_lahir_ibu, '') AS tahun_lahir_ibu, COALESCE(ot.nik_ibu, '') AS nik_ibu,
        COALESCE(ot.pekerjaan_ibu, '') AS pekerjaan_ibu, COALESCE(ot.pendidikan_ibu, '') AS pendidikan_ibu, COALESCE(ot.penghasilan_ibu, '') AS penghasilan_ibu,
        COALESCE(w.nama_wali, '') AS nama_wali, COALESCE(w.tahun_lahir_wali, '') AS tahun_lahir_wali, 
        COALESCE(w.pekerjaan_wali, '') AS pekerjaan_wali, COALESCE(w.pendidikan_wali, '') AS pendidikan_wali, COALESCE(w.penghasilan_wali, '') AS penghasilan_wali,
        COALESCE(dp.tinggi_badan, '') AS tinggi_badan, COALESCE(dp.jarak_tempuh_km, '') AS jarak_tempuh_km, 
        COALESCE(dp.waktu_tempuh_menit, '') AS waktu_tempuh_menit, COALESCE(dp.berat_badan, '') AS berat_badan,
        COALESCE(dp.hobi, '') AS hobi, COALESCE(dp.cita_cita, '') AS cita_cita, COALESCE(dp.jumlah_saudara_kandung, '') AS jumlah_saudara_kandung
     FROM peserta_didik pd
     LEFT JOIN orang_tua ot ON pd.id = ot.peserta_id
     LEFT JOIN wali w ON pd.id = w.peserta_id
     LEFT JOIN data_periodik dp ON pd.id = dp.peserta_id";

$result = $conn->query($sql);
$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Buat file Excel
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header Kolom
$headers = [
    'Nama Lengkap', 'Jenis Kelamin', 'NISN', 'No. Ijazah', 'No. Ujian', 'No. KK', 'NIK', 'Sekolah Asal',
    'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'Alamat', 'Kelurahan', 'Kecamatan', 'Kabupaten', 'Provinsi',
    'Kode Pos', 'Alat Transportasi', 'No. HP', 'No. KIP', 'Nama KIP',
    'Nama Ayah', 'Tahun Lahir Ayah', 'NIK Ayah', 'Pekerjaan Ayah', 'Pendidikan Ayah', 'Penghasilan Ayah',
    'Nama Ibu', 'Tahun Lahir Ibu', 'NIK Ibu', 'Pekerjaan Ibu', 'Pendidikan Ibu', 'Penghasilan Ibu',
    'Nama Wali', 'Tahun Lahir Wali', 'Pekerjaan Wali', 'Pendidikan Wali', 'Penghasilan Wali',
    'Tinggi Badan', 'Jarak Tempuh (km)', 'Waktu Tempuh (menit)', 'Berat Badan', 'Hobi', 'Cita-Cita', 'Jumlah Saudara Kandung'
];

$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col++ . '1', $header);
}

// Isi Data
$rowIndex = 2; 
foreach ($data as $row) {
    $col = 'A';
    
    // Data Peserta Didik
    foreach ([
        'nama_lengkap', 'jenis_kelamin', 'nisn', 'no_ijazah', 'no_ujian', 'no_kk', 'nik', 'sekolah_asal',
        'tempat_lahir'
    ] as $field) {
        $sheet->setCellValueExplicit($col++ . $rowIndex, $row[$field], DataType::TYPE_STRING);
    }
    
    // Format tanggal agar tidak berubah di Excel
    $sheet->setCellValue($col . $rowIndex, \PhpOffice\PhpSpreadsheet\Shared\Date::PHPToExcel(strtotime($row['tanggal_lahir'])));
    $sheet->getStyle($col++ . $rowIndex)->getNumberFormat()->setFormatCode('yyyy-mm-dd');
    
    foreach ([
        'agama', 'alamat', 'kelurahan', 'kecamatan', 'kabupaten', 'provinsi', 'kode_pos', 'alat_transportasi', 'no_hp', 'no_kip', 'nama_kip',
        'nama_ayah', 'tahun_lahir_ayah', 'nik_ayah', 'pekerjaan_ayah', 'pendidikan_ayah', 'penghasilan_ayah',
        'nama_ibu', 'tahun_lahir_ibu', 'nik_ibu', 'pekerjaan_ibu', 'pendidikan_ibu', 'penghasilan_ibu',
        'nama_wali', 'tahun_lahir_wali', 'pekerjaan_wali', 'pendidikan_wali', 'penghasilan_wali',
        'tinggi_badan', 'jarak_tempuh_km', 'waktu_tempuh_menit', 'berat_badan', 'hobi', 'cita_cita', 'jumlah_saudara_kandung'
    ] as $field) {
        $sheet->setCellValueExplicit($col++ . $rowIndex, $row[$field], DataType::TYPE_STRING);
    }
    
    $rowIndex++;
}

// Export file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Data_Peserta_Didik.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit();
?>
