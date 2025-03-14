<?php
// Koneksi ke database
require 'config.php';

// Proses penyimpanan data jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $peserta_id = $_POST['peserta_id'];
    $tinggi_badan = $_POST['tinggi_badan'];
    $jarak_tempuh_km = $_POST['jarak_tempuh_km'];
    $waktu_tempuh_menit = $_POST['waktu_tempuh_menit'];
    $berat_badan = $_POST['berat_badan'];
    $hobi = $_POST['hobi'];
    $cita_cita = $_POST['cita_cita'];
    $jumlah_saudara_kandung = $_POST['jumlah_saudara_kandung'];

    // Simpan ke database
    $sql = "INSERT INTO data_periodik 
            (peserta_id, tinggi_badan, jarak_tempuh_km, waktu_tempuh_menit, berat_badan, hobi, cita_cita, jumlah_saudara_kandung) 
            VALUES ('$peserta_id', '$tinggi_badan', '$jarak_tempuh_km', '$waktu_tempuh_menit', '$berat_badan', '$hobi', '$cita_cita', '$jumlah_saudara_kandung')";

    if ($conn->query($sql) === TRUE) {
        // Redirect ke halaman selesai.php setelah data berhasil disimpan
        header("Location: selesai.php");
        exit; // Menghentikan eksekusi lebih lanjut
    } else {
        $error_message = "Error: " . $conn->error;
    }
}

// Ambil daftar peserta didik
$pesertaQuery = "SELECT id, nama_lengkap FROM peserta_didik";
$pesertaResult = $conn->query($pesertaQuery);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Periodik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
    <h2 class="text-2xl font-bold mb-4 text-center">Form Data Tambahan Peserta</h2>

    <?php if (isset($error_message)): ?>
        <div class="bg-red-200 text-red-800 p-3 rounded mb-4"><?= $error_message; ?></div>
    <?php endif; ?>

    <form action="" method="POST" class="space-y-4">
        <!-- Pilih Peserta -->
        <div>
            <label class="block text-gray-700 font-semibold">Peserta Didik</label>
            <select class="w-full border border-gray-300 rounded p-2" name="peserta_id" required>
                <option value="">Pilih Peserta</option>
                <?php while ($row = $pesertaResult->fetch_assoc()): ?>
                    <option value="<?= $row['id']; ?>"><?= $row['nama_lengkap']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <!-- Tinggi Badan -->
        <div>
            <label class="block text-gray-700 font-semibold">Tinggi Badan (cm)</label>
            <input type="number" step="0.1" class="w-full border border-gray-300 rounded p-2" name="tinggi_badan" required>
        </div>

        <!-- Jarak Tempuh ke Sekolah -->
        <div>
            <label class="block text-gray-700 font-semibold">Jarak Tempuh ke Sekolah (km)</label>
            <input type="number" step="0.1" class="w-full border border-gray-300 rounded p-2" name="jarak_tempuh_km" required>
        </div>

        <!-- Waktu Tempuh ke Sekolah -->
        <div>
            <label class="block text-gray-700 font-semibold">Waktu Tempuh ke Sekolah (menit)</label>
            <input type="number" class="w-full border border-gray-300 rounded p-2" name="waktu_tempuh_menit" required>
        </div>

        <!-- Berat Badan -->
        <div>
            <label class="block text-gray-700 font-semibold">Berat Badan (kg)</label>
            <input type="number" step="0.1" class="w-full border border-gray-300 rounded p-2" name="berat_badan" required>
        </div>

        <!-- Hobi -->
        <div>
            <label class="block text-gray-700 font-semibold">Hobi</label>
            <input type="text" class="w-full border border-gray-300 rounded p-2" name="hobi" required>
        </div>

        <!-- Cita-Cita -->
        <div>
            <label class="block text-gray-700 font-semibold">Cita-Cita</label>
            <input type="text" class="w-full border border-gray-300 rounded p-2" name="cita_cita" required>
        </div>

        <!-- Jumlah Saudara Kandung -->
        <div>
            <label class="block text-gray-700 font-semibold">Jumlah Saudara Kandung</label>
            <input type="number" class="w-full border border-gray-300 rounded p-2" name="jumlah_saudara_kandung" required>
        </div>

        <!-- Tombol Submit -->
        <div class="text-center">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Simpan Data
            </button>
        </div>
    </form>
</div>

</body>
</html>

<?php $conn->close(); ?>
