<?php
// Mulai session
session_start();

// Koneksi ke database
require '../config.php';

// Cek apakah peserta_id ada di session
if (!isset($_SESSION['peserta_id'])) {
    header("Location: index.php"); // Redirect jika tidak login
    exit();
}

$peserta_id = $_SESSION['peserta_id'];

// Ambil nama peserta berdasarkan peserta_id
$query = "SELECT nama_lengkap FROM peserta_didik WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $peserta_id);
$stmt->execute();
$result = $stmt->get_result();
$peserta = $result->fetch_assoc();
$nama_peserta = $peserta['nama_lengkap'] ?? 'Tidak ditemukan';

// Proses penyimpanan data jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idddsssi", $peserta_id, $tinggi_badan, $jarak_tempuh_km, $waktu_tempuh_menit, $berat_badan, $hobi, $cita_cita, $jumlah_saudara_kandung);

    if ($stmt->execute()) {
        header("Location: selesai.php"); // Redirect ke halaman selesai
        exit();
    } else {
        $error_message = "Error: " . $conn->error;
    }
}
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
            <!-- Nama Peserta (Non-Editable) -->
            <div>
                <label class="block text-gray-700 font-semibold">Peserta Didik</label>
                <input type="text" class="w-full border border-gray-300 rounded p-2 bg-gray-200 cursor-not-allowed"
                    value="<?= htmlspecialchars($nama_peserta); ?>" disabled>
                <input type="hidden" name="peserta_id" value="<?= $peserta_id; ?>">
            </div>

            <!-- Tinggi Badan -->
            <div>
                <label class="block text-gray-700 font-semibold">Tinggi Badan (cm)</label>
                <input type="number" step="0.1" class="w-full border border-gray-300 rounded p-2" name="tinggi_badan"
                    required>
            </div>

            <!-- Jarak Tempuh ke Sekolah -->
            <div>
                <label class="block text-gray-700 font-semibold">Jarak Tempuh ke Sekolah (km)</label>
                <input type="number" step="0.1" class="w-full border border-gray-300 rounded p-2" name="jarak_tempuh_km"
                    required>
            </div>

            <!-- Waktu Tempuh ke Sekolah -->
            <div>
                <label class="block text-gray-700 font-semibold">Waktu Tempuh ke Sekolah (menit)</label>
                <input type="number" class="w-full border border-gray-300 rounded p-2" name="waktu_tempuh_menit"
                    required>
            </div>

            <!-- Berat Badan -->
            <div>
                <label class="block text-gray-700 font-semibold">Berat Badan (kg)</label>
                <input type="number" step="0.1" class="w-full border border-gray-300 rounded p-2" name="berat_badan"
                    required>
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
                <input type="number" class="w-full border border-gray-300 rounded p-2" name="jumlah_saudara_kandung"
                    required>
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