<?php
session_start();
require '../config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['peserta_id'])) {
    header("Location: index.php"); // Redirect ke halaman login jika tidak ada sesi
    exit();
}

$peserta_id = $_SESSION['peserta_id']; // Ambil peserta_id dari sesi
$message = ""; // Variabel untuk pesan error/sukses

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['tidak_punya_wali'])) {
        $nama_wali = !empty($_POST['nama_wali']) ? $_POST['nama_wali'] : NULL;
        $tahun_lahir_wali = !empty($_POST['tahun_lahir_wali']) ? $_POST['tahun_lahir_wali'] : NULL;
        $pekerjaan_wali = !empty($_POST['pekerjaan_wali']) ? $_POST['pekerjaan_wali'] : NULL;
        $pendidikan_wali = !empty($_POST['pendidikan_wali']) ? $_POST['pendidikan_wali'] : NULL;
        $penghasilan_wali = !empty($_POST['penghasilan_wali']) ? $_POST['penghasilan_wali'] : NULL;
    } else {
        $nama_wali = $tahun_lahir_wali = $pekerjaan_wali = $pendidikan_wali = $penghasilan_wali = NULL;
    }

    // Simpan ke database hanya jika peserta_id valid
    if (!empty($peserta_id)) {
        $stmt = $conn->prepare("INSERT INTO wali (peserta_id, nama_wali, tahun_lahir_wali, pekerjaan_wali, pendidikan_wali, penghasilan_wali) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $peserta_id, $nama_wali, $tahun_lahir_wali, $pekerjaan_wali, $pendidikan_wali, $penghasilan_wali);

        if ($stmt->execute()) {
            header("Location: data_periodik.php"); // Redirect ke halaman berikutnya
            exit();
        } else {
            $message = "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $message = "Terjadi kesalahan: peserta tidak ditemukan.";
    }
}

$conn->close();
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

        <?php if (!empty($message)) : ?>
        <p class="text-center text-red-500 font-medium"><?= htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <input type="hidden" name="peserta_id" value="<?= htmlspecialchars($peserta_id); ?>">

            <div>
                <input type="checkbox" id="tidak_punya_wali" name="tidak_punya_wali" onclick="toggleFields()">
                <label for="tidak_punya_wali" class="font-medium text-gray-700">Tidak memiliki wali</label>
            </div>

            <div class="wali-fields">
                <div>
                    <label for="nama_wali" class="block font-medium text-gray-700">Nama Wali:</label>
                    <input type="text" id="nama_wali" name="nama_wali" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label for="tahun_lahir_wali" class="block font-medium text-gray-700">Tahun Lahir:</label>
                    <input type="number" id="tahun_lahir_wali" name="tahun_lahir_wali" min="1900"
                        max="<?= date('Y'); ?>" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label for="pekerjaan_wali" class="block font-medium text-gray-700">Pekerjaan:</label>
                    <input type="text" id="pekerjaan_wali" name="pekerjaan_wali" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label for="pendidikan_wali" class="block font-medium text-gray-700">Pendidikan:</label>
                    <input type="text" id="pendidikan_wali" name="pendidikan_wali" class="w-full border rounded-lg p-2">
                </div>

                <div>
                    <label for="penghasilan_wali" class="block font-medium text-gray-700">Penghasilan:</label>
                    <input type="text" id="penghasilan_wali" name="penghasilan_wali"
                        class="w-full border rounded-lg p-2">
                </div>
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg">Simpan</button>
        </form>
    </div>

    <script>
    function toggleFields() {
        let checkbox = document.getElementById("tidak_punya_wali");
        let fields = document.querySelectorAll(".wali-fields input");
        fields.forEach(field => {
            field.disabled = checkbox.checked;
            if (checkbox.checked) {
                field.value = ""; // Kosongkan input jika checkbox dicentang
            }
        });
    }
    window.onload = function() {
        toggleFields();
    };
    </script>
</body>

</html>