<?php
require __DIR__ . '/../vendor/autoload.php';
include 'config.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Header kolom
$headers = [
    'No', 'Nama Lengkap', 'NISN', 'Jenis Kelamin', 'No Ijazah', 'No Ujian', 'No KK', 'NIK',
    'Sekolah Asal', 'Tempat Lahir', 'Tanggal Lahir', 'Agama', 'Alamat', 'Kelurahan',
    'Kecamatan', 'Kabupaten', 'Provinsi', 'Kode Pos', 'Alat Transportasi', 'No HP',
    'No KIP', 'Nama KIP'
];

// Set header ke dalam Excel
$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col . '1', $header);
    $col++;
}

// Ambil data dari database
$query = "SELECT * FROM peserta_didik";
$result = mysqli_query($conn, $query);

$rowIndex = 2; 
$no = 1;
while ($row = mysqli_fetch_assoc($result)) {
    $col = 'A';
    $sheet->setCellValue($col++ . $rowIndex, $no++);
    $sheet->setCellValue($col++ . $rowIndex, $row['nama_lengkap']);
    $sheet->setCellValue($col++ . $rowIndex, $row['nisn']);
    $sheet->setCellValue($col++ . $rowIndex, $row['jenis_kelamin']);
    $sheet->setCellValue($col++ . $rowIndex, $row['no_ijazah']);
    $sheet->setCellValue($col++ . $rowIndex, $row['no_ujian']);
    $sheet->setCellValue($col++ . $rowIndex, $row['no_kk']);
    $sheet->setCellValue($col++ . $rowIndex, $row['nik']);
    $sheet->setCellValue($col++ . $rowIndex, $row['sekolah_asal']);
    $sheet->setCellValue($col++ . $rowIndex, $row['tempat_lahir']);
    $sheet->setCellValue($col++ . $rowIndex, $row['tanggal_lahir']);
    $sheet->setCellValue($col++ . $rowIndex, $row['agama']);
    $sheet->setCellValue($col++ . $rowIndex, $row['alamat']);
    $sheet->setCellValue($col++ . $rowIndex, $row['kelurahan']);
    $sheet->setCellValue($col++ . $rowIndex, $row['kecamatan']);
    $sheet->setCellValue($col++ . $rowIndex, $row['kabupaten']);
    $sheet->setCellValue($col++ . $rowIndex, $row['provinsi']);
    $sheet->setCellValue($col++ . $rowIndex, $row['kode_pos']);
    $sheet->setCellValue($col++ . $rowIndex, $row['alat_transportasi']);
    $sheet->setCellValue($col++ . $rowIndex, $row['no_hp']);
    $sheet->setCellValue($col++ . $rowIndex, $row['no_kip']);
    $sheet->setCellValue($col++ . $rowIndex, $row['nama_kip']);
    $rowIndex++;
}

// Buat file Excel
$writer = new Xlsx($spreadsheet);
$filename = 'Data_Peserta_Didik.xlsx';

// Header untuk download
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
exit;
?>
