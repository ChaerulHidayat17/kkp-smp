<?php
session_start();
require '../config.php';

// Debug session
if (!isset($_SESSION['valid_access']) || $_SESSION['valid_access'] !== true) {
    header("Location: index.php");
    exit();
}

// Pastikan peserta_id ada di session
if (!isset($_SESSION['peserta_id'])) {
    echo "<div class='bg-red-500 text-white p-3 rounded-md'>Session peserta_id tidak ditemukan.</div>";
    exit();
}

$peserta_id = $_SESSION['peserta_id']; // Ambil peserta_id dari session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tidak_punya_ayah = isset($_POST['tidak_punya_ayah']);
    $tidak_punya_ibu = isset($_POST['tidak_punya_ibu']);

    $data = [
        'nama_ayah' => $tidak_punya_ayah ? null : trim($_POST['nama_ayah']),
        'tahun_lahir_ayah' => $tidak_punya_ayah ? null : trim($_POST['tahun_lahir_ayah']),
        'nik_ayah' => $tidak_punya_ayah ? null : trim($_POST['nik_ayah']),
        'pekerjaan_ayah' => $tidak_punya_ayah ? null : trim($_POST['pekerjaan_ayah']),
        'pendidikan_ayah' => $tidak_punya_ayah ? null : trim($_POST['pendidikan_ayah']),
        'penghasilan_ayah' => $tidak_punya_ayah ? null : trim($_POST['penghasilan_ayah']),

        'nama_ibu' => $tidak_punya_ibu ? null : trim($_POST['nama_ibu']),
        'tahun_lahir_ibu' => $tidak_punya_ibu ? null : trim($_POST['tahun_lahir_ibu']),
        'nik_ibu' => $tidak_punya_ibu ? null : trim($_POST['nik_ibu']),
        'pekerjaan_ibu' => $tidak_punya_ibu ? null : trim($_POST['pekerjaan_ibu']),
        'pendidikan_ibu' => $tidak_punya_ibu ? null : trim($_POST['pendidikan_ibu']),
        'penghasilan_ibu' => $tidak_punya_ibu ? null : trim($_POST['penghasilan_ibu'])
    ];

    $query = "INSERT INTO orang_tua 
        (peserta_id, nama_ayah, tahun_lahir_ayah, nik_ayah, pekerjaan_ayah, pendidikan_ayah, penghasilan_ayah, 
        nama_ibu, tahun_lahir_ibu, nik_ibu, pekerjaan_ibu, pendidikan_ibu, penghasilan_ibu) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);
    if ($stmt) {
        $stmt->bind_param(
            "issssssssssss",
            $peserta_id,
            $data['nama_ayah'], $data['tahun_lahir_ayah'], $data['nik_ayah'],
            $data['pekerjaan_ayah'], $data['pendidikan_ayah'], $data['penghasilan_ayah'],
            $data['nama_ibu'], $data['tahun_lahir_ibu'], $data['nik_ibu'],
            $data['pekerjaan_ibu'], $data['pendidikan_ibu'], $data['penghasilan_ibu']
        );

        if ($stmt->execute()) {
            $_SESSION['valid_access'] = false;
            header("Location: wali.php");
            exit();
        } else {
            $message = "<div class='bg-red-500 text-white p-3 rounded-md'>Gagal menyimpan data: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        $message = "<div class='bg-red-500 text-white p-3 rounded-md'>Gagal menyiapkan statement: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Orang Tua</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-4 text-center">Formulir Data Orang Tua</h2>

        <?php if (!empty($message)) echo $message; ?>

        <form action="" method="post" class="space-y-4">
            <!-- Data Ayah -->
            <fieldset class="border p-4 rounded-lg">
                <legend class="text-lg font-semibold">Data Ayah</legend>
                <label class="flex items-center mb-2">
                    <input type="checkbox" name="tidak_punya_ayah" id="tidak_punya_ayah" class="mr-2"> Tidak punya ayah
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="nama_ayah" id="nama_ayah" placeholder="Nama Ayah"
                        class="ayah-input p-2 border rounded">
                    <input type="text" name="tahun_lahir_ayah" id="tahun_lahir_ayah" placeholder="Tahun Lahir"
                        class="ayah-input p-2 border rounded">
                    <input type="text" name="nik_ayah" id="nik_ayah" placeholder="NIK"
                        class="ayah-input p-2 border rounded">
                    <input type="text" name="pekerjaan_ayah" id="pekerjaan_ayah" placeholder="Pekerjaan"
                        class="ayah-input p-2 border rounded">
                    <input type="text" name="pendidikan_ayah" id="pendidikan_ayah" placeholder="Pendidikan"
                        class="ayah-input p-2 border rounded">
                    <input type="text" name="penghasilan_ayah" id="penghasilan_ayah" placeholder="Penghasilan"
                        class="ayah-input p-2 border rounded">
                </div>
            </fieldset>

            <!-- Data Ibu -->
            <fieldset class="border p-4 rounded-lg">
                <legend class="text-lg font-semibold">Data Ibu</legend>
                <label class="flex items-center mb-2">
                    <input type="checkbox" name="tidak_punya_ibu" id="tidak_punya_ibu" class="mr-2"> Tidak punya ibu
                </label>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" name="nama_ibu" id="nama_ibu" placeholder="Nama Ibu"
                        class="ibu-input p-2 border rounded">
                    <input type="text" name="tahun_lahir_ibu" id="tahun_lahir_ibu" placeholder="Tahun Lahir"
                        class="ibu-input p-2 border rounded">
                    <input type="text" name="nik_ibu" id="nik_ibu" placeholder="NIK"
                        class="ibu-input p-2 border rounded">
                    <input type="text" name="pekerjaan_ibu" id="pekerjaan_ibu" placeholder="Pekerjaan"
                        class="ibu-input p-2 border rounded">
                    <input type="text" name="pendidikan_ibu" id="pendidikan_ibu" placeholder="Pendidikan"
                        class="ibu-input p-2 border rounded">
                    <input type="text" name="penghasilan_ibu" id="penghasilan_ibu" placeholder="Penghasilan"
                        class="ibu-input p-2 border rounded">
                </div>
            </fieldset>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
                Simpan Data
            </button>
        </form>
    </div>

    <script>
    function toggleInputs(checkboxId, inputClass) {
        document.getElementById(checkboxId).addEventListener('change', function() {
            document.querySelectorAll('.' + inputClass).forEach(input => {
                input.disabled = this.checked;
                input.value = this.checked ? '' : input.value;
            });
        });
    }

    toggleInputs("tidak_punya_ayah", "ayah-input");
    toggleInputs("tidak_punya_ibu", "ibu-input");
    </script>
</body>

</html>