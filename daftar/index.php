<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = $_POST['nama_lengkap'] ?? '';
    $jenis_kelamin = $_POST['jenis_kelamin'] ?? '';
    $nisn = $_POST['nisn'] ?? '';
    $no_ijazah = $_POST['no_ijazah'] ?? '';
    $no_ujian = $_POST['no_ujian'] ?? '';
    $no_kk = $_POST['no_kk'] ?? '';
    $nik = $_POST['nik'] ?? '';
    $sekolah_asal = $_POST['sekolah_asal'] ?? '';
    $tempat_lahir = $_POST['tempat_lahir'] ?? '';
    $tanggal_lahir = $_POST['tanggal_lahir'] ?? '';
    $agama = $_POST['agama'] ?? '';
    $alamat = $_POST['alamat'] ?? null;
    $kelurahan = $_POST['kelurahan'] ?? '';
    $kecamatan = $_POST['kecamatan'] ?? '';
    $kabupaten = $_POST['kabupaten'] ?? '';
    $provinsi = $_POST['provinsi'] ?? '';
    $kode_pos = $_POST['kode_pos'] ?? '';
    $alat_transportasi = $_POST['alat_transportasi'] ?? '';
    $no_hp = $_POST['no_hp'] ?? '';
    $no_kip = $_POST['no_kip'] ?? null;
    $nama_kip = $_POST['nama_kip'] ?? null;

    // Cek apakah NISN atau NIK sudah ada dalam database
    $check_query = "SELECT id FROM peserta_didik WHERE nisn = ? OR nik = ?";
    $stmt_check = $conn->prepare($check_query);
    $stmt_check->bind_param("ss", $nisn, $nik);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $message = "Data dengan NISN atau NIK ini sudah terdaftar.";
    } else {
        $query = "INSERT INTO peserta_didik (nama_lengkap, jenis_kelamin, nisn, no_ijazah, no_ujian, no_kk, nik, sekolah_asal, tempat_lahir, tanggal_lahir, agama, alamat, kelurahan, kecamatan, kabupaten, provinsi, kode_pos, alat_transportasi, no_hp, no_kip, nama_kip) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssssssssssssssssss", 
            $nama_lengkap, $jenis_kelamin, $nisn, $no_ijazah, $no_ujian, $no_kk, $nik, $sekolah_asal, $tempat_lahir, $tanggal_lahir, 
            $agama, $alamat, $kelurahan, $kecamatan, $kabupaten, $provinsi, $kode_pos, $alat_transportasi, $no_hp, $no_kip, $nama_kip
        );

        if ($stmt->execute()) {
            header("Location: orang_tua.php");
            exit();
        } else {
            $message = "Terjadi kesalahan: " . $stmt->error;
        }
    }

    $stmt_check->close();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Peserta Didik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md mt-10 rounded">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-700">Form Pendaftaran Peserta Didik</h2>

        <?php if (isset($message)): ?>
            <div class="p-4 mb-4 text-red-800 bg-red-200 rounded">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <?php
                $fields = [
                    "nama_lengkap" => "Nama Lengkap",
                    "jenis_kelamin" => "Jenis Kelamin",
                    "nisn" => "NISN",
                    "no_ijazah" => "No Ijazah",
                    "no_ujian" => "No Ujian",
                    "no_kk" => "No KK",
                    "nik" => "NIK",
                    "sekolah_asal" => "Sekolah Asal",
                    "tempat_lahir" => "Tempat Lahir",
                    "tanggal_lahir" => "Tanggal Lahir",
                    "agama" => "Agama",
                    "alamat" => "Alamat",
                    "kelurahan" => "Kelurahan",
                    "kecamatan" => "Kecamatan",
                    "kabupaten" => "Kabupaten",
                    "provinsi" => "Provinsi",
                    "kode_pos" => "Kode Pos",
                    "alat_transportasi" => "Alat Transportasi",
                    "no_hp" => "No HP",
                    "no_kip" => "No KIP (Opsional)",
                    "nama_kip" => "Nama KIP (Opsional)"
                ];

                foreach ($fields as $name => $label) {
                    echo '<div>';
                    echo "<label class='block text-gray-700 font-medium'>$label:</label>";
                    if ($name === "jenis_kelamin") {
                        echo "<select name='$name' required class='w-full p-2 border rounded bg-gray-50 focus:ring-2 focus:ring-blue-300'>
                                <option value='Laki-laki'>Laki-laki</option>
                                <option value='Perempuan'>Perempuan</option>
                              </select>";
                    } elseif ($name === "alamat") {
                        echo "<textarea name='$name' class='w-full p-2 border rounded bg-gray-50 focus:ring-2 focus:ring-blue-300'></textarea>";
                    } else {
                        $type = ($name === "tanggal_lahir") ? "date" : "text";
                        $required = in_array($name, ["no_kip", "nama_kip", "alamat"]) ? "" : "required";
                        echo "<input type='$type' name='$name' $required class='w-full p-2 border rounded bg-gray-50 focus:ring-2 focus:ring-blue-300'>";
                    }
                    echo '</div>';
                }
                ?>
            </div>

            <div class="text-center">
                <button type="submit" class="mt-6 px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:ring-2 focus:ring-blue-300">Daftar</button>
            </div>
        </form>
    </div>
</body>
</html>
