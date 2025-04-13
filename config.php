<?php


// Load file .env
$dotenv = parse_ini_file(__DIR__ . '/.env');
if (!$dotenv) {
    die("Gagal memuat file .env. Pastikan file .env ada dan dapat dibaca.");
}

foreach ($dotenv as $key => $value) {
    putenv("$key=$value");
}

// Konfigurasi Database
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$password = getenv('DB_PASSWORD') ?: '';
$database = getenv('DB_NAME') ?: 'ppdb_online';

try {
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
    $conn = new mysqli($host, $user, $password, $database);
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>