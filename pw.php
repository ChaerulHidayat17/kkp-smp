<?php
require 'config.php'; // Pastikan ada file koneksi ke database

$username = "admin";
$password = "admin123"; // Password asli
$hashed_password = password_hash($password, PASSWORD_BCRYPT); // Hash password

$sql = "INSERT INTO admin (username, password) VALUES (?, ?)";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);

if (mysqli_stmt_execute($stmt)) {
    echo "Admin berhasil ditambahkan!";
} else {
    echo "Error: " . mysqli_error($conn);
}

mysqli_close($conn);
?>
