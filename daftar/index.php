<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nisn = $_POST['nisn'];
    $no_ijazah = $_POST['no_ijazah'];
    $no_ujian = $_POST['no_ujian'];
    $no_kk = $_POST['no_kk'];
    $nik = $_POST['nik'];
    $sekolah_asal = $_POST['sekolah_asal'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $agama = $_POST['agama']; // Tambahkan agama
    $alamat = $_POST['alamat'];
    $kelurahan = $_POST['kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $kabupaten = $_POST['kabupaten'];
    $provinsi = $_POST['provinsi'];
    $kode_pos = $_POST['kode_pos'];
    $alat_transportasi = $_POST['alat_transportasi'];
    $no_hp = $_POST['no_hp'];
    $no_kip = isset($_POST['no_kip']) ? $_POST['no_kip'] : '';
    $nama_kip = isset($_POST['nama_kip']) ? $_POST['nama_kip'] : '';

    // Cek apakah data dengan NISN atau NIK sudah ada
    $check_query = "SELECT id FROM peserta_didik WHERE nisn = ? OR nik = ?";
    $stmt_check = $conn->prepare($check_query);
    $stmt_check->bind_param("ss", $nisn, $nik);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "Data sudah ada dalam database.";
    } else {
        // Query untuk memasukkan data
        $query = "INSERT INTO peserta_didik (nama_lengkap, jenis_kelamin, nisn, no_ijazah, no_ujian, no_kk, nik, sekolah_asal, tempat_lahir, tanggal_lahir, agama, alamat, kelurahan, kecamatan, kabupaten, provinsi, kode_pos, alat_transportasi, no_hp, no_kip, nama_kip) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssssssssssssssss", 
            $nama_lengkap, $jenis_kelamin, $nisn, $no_ijazah, $no_ujian, $no_kk, $nik, $sekolah_asal, $tempat_lahir, $tanggal_lahir, 
            $agama, $alamat, $kelurahan, $kecamatan, $kabupaten, $provinsi, $kode_pos, $alat_transportasi, $no_hp, $no_kip, $nama_kip
        );

        if ($stmt->execute()) {
            echo "Pendaftaran berhasil.";
        } else {
            echo "Terjadi kesalahan: " . $stmt->error;
        }
    }

    $stmt_check->close();
    $stmt->close();
    $conn->close();
}
?>
