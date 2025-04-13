<?php
session_start();
include '../config.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    echo json_encode(['status' => 'error', 'message' => 'Anda harus login']);
    exit;
}

// Pastikan ID dikirim melalui GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Hindari SQL Injection dengan memastikan ID adalah integer
    
    // Hapus data dari database
    $query = "DELETE FROM peserta_didik WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        // Redirect ke halaman data_siswa.php setelah berhasil menghapus
        header("Location: data_siswa.php");
        exit;
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Gagal menghapus data']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak ditemukan']);
}
?>
