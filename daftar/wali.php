<?php
// Koneksi ke database
require 'config.php';

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses penyimpanan jika form dikirim
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $peserta_id = $_POST['peserta_id'];
    $nama_wali = !empty($_POST['nama_wali']) ? $_POST['nama_wali'] : NULL;
    $tahun_lahir_wali = !empty($_POST['tahun_lahir_wali']) ? $_POST['tahun_lahir_wali'] : NULL;
    $pekerjaan_wali = !empty($_POST['pekerjaan_wali']) ? $_POST['pekerjaan_wali'] : NULL;
    $pendidikan_wali = !empty($_POST['pendidikan_wali']) ? $_POST['pendidikan_wali'] : NULL;
    $penghasilan_wali = !empty($_POST['penghasilan_wali']) ? $_POST['penghasilan_wali'] : NULL;

    // Simpan ke database
    $stmt = $conn->prepare("INSERT INTO wali (peserta_id, nama_wali, tahun_lahir_wali, pekerjaan_wali, pendidikan_wali, penghasilan_wali) 
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $peserta_id, $nama_wali, $tahun_lahir_wali, $pekerjaan_wali, $pendidikan_wali, $penghasilan_wali);

    if ($stmt->execute()) {
        // Redirect ke data_periodik.php setelah penyimpanan sukses
        header("Location: data_periodik.php");
        exit();
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Ambil daftar peserta didik untuk dropdown
$pesertaQuery = "SELECT id, nama_lengkap FROM peserta_didik";
$pesertaResult = $conn->query($pesertaQuery);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Wali</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <h2 class="text-2xl font-semibold text-gray-700 text-center mb-4">Form Data Wali</h2>

        <?php if (isset($message)) : ?>
            <p class="text-center text-red-500 font-medium"><?= $message; ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label for="peserta_id" class="block font-medium text-gray-700">Peserta Didik:</label>
                <select name="peserta_id" required class="w-full border rounded-lg p-2">
                    <option value="">-- Pilih Peserta --</option>
                    <?php while ($row = $pesertaResult->fetch_assoc()) : ?>
                        <option value="<?= $row['id']; ?>"><?= $row['nama_lengkap']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label for="nama_wali" class="block font-medium text-gray-700">Nama Wali:</label>
                <input type="text" name="nama_wali" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label for="tahun_lahir_wali" class="block font-medium text-gray-700">Tahun Lahir:</label>
                <input type="number" name="tahun_lahir_wali" min="1900" max="<?= date('Y'); ?>" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label for="pekerjaan_wali" class="block font-medium text-gray-700">Pekerjaan:</label>
                <input type="text" name="pekerjaan_wali" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label for="pendidikan_wali" class="block font-medium text-gray-700">Pendidikan:</label>
                <input type="text" name="pendidikan_wali" class="w-full border rounded-lg p-2">
            </div>

            <div>
                <label for="penghasilan_wali" class="block font-medium text-gray-700">Penghasilan:</label>
                <input type="text" name="penghasilan_wali" class="w-full border rounded-lg p-2">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg">Simpan</button>
        </form>
    </div>

</body>
</html>

<?php $conn->close(); ?>  
