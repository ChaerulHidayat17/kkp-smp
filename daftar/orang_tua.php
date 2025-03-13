<?php
require 'config.php';

// Ambil ID peserta terakhir dari tabel peserta_didik
$query = "SELECT id FROM peserta_didik ORDER BY id DESC LIMIT 1";
$result = $conn->query($query);
$row = $result->fetch_assoc();
$peserta_id = intval($row['id'] ?? 0);

if ($peserta_id == 0) {
    die("<div class='bg-red-500 text-white p-3 rounded-md'>Error: Tidak ada ID peserta didik yang ditemukan.</div>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields = ['nama_ayah', 'tahun_lahir_ayah', 'nik_ayah', 'pekerjaan_ayah', 'pendidikan_ayah', 'penghasilan_ayah',
               'nama_ibu', 'tahun_lahir_ibu', 'nik_ibu', 'pekerjaan_ibu', 'pendidikan_ibu', 'penghasilan_ibu'];
    
    $data = [];
    foreach ($fields as $field) {
        $data[$field] = $_POST[$field] ?? '';
    }

    if (empty($data['nama_ayah']) || empty($data['nama_ibu'])) {
        $message = "<div class='bg-red-500 text-white p-3 rounded-md'>Nama Ayah dan Nama Ibu harus diisi.</div>";
    } else {
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
                header("Location: data_periodik.php");
                exit();
            } else {
                $message = "<div class='bg-red-500 text-white p-3 rounded-md'>Gagal menyimpan data: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            $message = "<div class='bg-red-500 text-white p-3 rounded-md'>Gagal menyiapkan statement.</div>";
        }
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
<body class="p-8 bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="max-w-2xl w-full bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-3xl font-bold mb-6 text-center text-gray-700">Data Orang Tua</h2>
        <?php echo $message ?? ''; ?>
        <form method="POST" action="" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <?php 
                $labels = [
                    'nama_ayah' => 'Nama Ayah', 'tahun_lahir_ayah' => 'Tahun Lahir Ayah', 'nik_ayah' => 'NIK Ayah', 
                    'pekerjaan_ayah' => 'Pekerjaan Ayah', 'pendidikan_ayah' => 'Pendidikan Ayah', 'penghasilan_ayah' => 'Penghasilan Ayah',
                    'nama_ibu' => 'Nama Ibu', 'tahun_lahir_ibu' => 'Tahun Lahir Ibu', 'nik_ibu' => 'NIK Ibu', 
                    'pekerjaan_ibu' => 'Pekerjaan Ibu', 'pendidikan_ibu' => 'Pendidikan Ibu', 'penghasilan_ibu' => 'Penghasilan Ibu'
                ];
                
                foreach ($labels as $name => $label) {
                    echo "<div>
                            <label class='block text-gray-700 font-semibold'>$label</label>
                            <input type='text' name='$name' class='w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400' required>
                          </div>";
                }
                ?>
            </div>
            <div class="flex justify-center mt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition duration-300">Selanjutnya ⏩</button>
            </div>
        </form>
    </div>
</body>
</html>
