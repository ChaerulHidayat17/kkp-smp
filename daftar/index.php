<?php
session_start();
$_SESSION['valid_access'] = true;
include '../config.php'; // Pastikan file config.php ada untuk koneksi database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_lengkap = $_POST['nama_lengkap'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $nisn = $_POST['nisn'];
    $no_ijazah = $_POST['no_ijazah'];
    $no_ujian = $_POST['no_ujian'];
    $no_kk = $_POST['no_kk'];
    $nik = $_POST['nik'];
    $sekolah_asal = $_POST['sekolah_asal'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $agama = $_POST['agama'];
    $alamat = !empty($_POST['alamat']) ? $_POST['alamat'] : NULL;
    $kelurahan = $_POST['kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $kabupaten = $_POST['kabupaten'];
    $provinsi = $_POST['provinsi'];
    $kode_pos = $_POST['kode_pos'];
    $alat_transportasi = $_POST['alat_transportasi'];
    $no_hp = $_POST['no_hp'];
    $no_kip = !empty($_POST['no_kip']) ? $_POST['no_kip'] : NULL;
    $nama_kip = !empty($_POST['nama_kip']) ? $_POST['nama_kip'] : NULL;

    // Simpan ke database
    $sql = "INSERT INTO peserta_didik (nama_lengkap, jenis_kelamin, nisn, no_ijazah, no_ujian, no_kk, nik, sekolah_asal, tempat_lahir, tanggal_lahir, agama, alamat, kelurahan, kecamatan, kabupaten, provinsi, kode_pos, alat_transportasi, no_hp, no_kip, nama_kip) 
            VALUES ('$nama_lengkap', '$jenis_kelamin', '$nisn', '$no_ijazah', '$no_ujian', '$no_kk', '$nik', '$sekolah_asal', '$tempat_lahir', '$tanggal_lahir', '$agama', NULLIF('$alamat', ''), '$kelurahan', '$kecamatan', '$kabupaten', '$provinsi', '$kode_pos', '$alat_transportasi', '$no_hp', NULLIF('$no_kip', ''), NULLIF('$nama_kip', ''))";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['peserta_id'] = $conn->insert_id;
        header("Location: orang_tua.php");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Pendaftaran Peserta Didik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-tr from-blue-50 to-purple-100 min-h-screen flex items-center justify-center px-4 py-10">
    <div class="bg-white/90 backdrop-blur-lg shadow-xl rounded-2xl w-full max-w-5xl p-8">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Form Pendaftaran Peserta Didik</h2>

        <?php if (isset($error)): ?>
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-center">
            <?= $error ?>
        </div>
        <?php endif; ?>

        <form method="POST">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" maxlength="255" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Jenis Kelamin</label>
                    <select name="jenis_kelamin" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                        <option value="">-- Pilih --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">NISN</label>
                    <input type="text" name="nisn" maxlength="20" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">No Ijazah</label>
                    <input type="text" name="no_ijazah" maxlength="50" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">No Ujian</label>
                    <input type="text" name="no_ujian" maxlength="50" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">No KK</label>
                    <input type="text" name="no_kk" maxlength="50" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">NIK</label>
                    <input type="text" name="nik" maxlength="50" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Sekolah Asal</label>
                    <input type="text" name="sekolah_asal" maxlength="255" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" maxlength="100" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Agama</label>
                    <input type="text" name="agama" maxlength="50" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div class="md:col-span-2">
                    <label class="block mb-1 font-medium text-gray-700">Alamat</label>
                    <textarea name="alamat" required rows="2"
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400"></textarea>
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Kelurahan</label>
                    <input type="text" name="kelurahan" maxlength="100" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Kecamatan</label>
                    <input type="text" name="kecamatan" maxlength="100" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Kabupaten</label>
                    <input type="text" name="kabupaten" maxlength="100" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Provinsi</label>
                    <input type="text" name="provinsi" maxlength="100" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Kode Pos</label>
                    <input type="text" name="kode_pos" maxlength="10" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Alat Transportasi</label>
                    <input type="text" name="alat_transportasi" maxlength="50" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">No HP</label>
                    <input type="text" name="no_hp" maxlength="20" required
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">No KIP (Opsional)</label>
                    <input type="text" name="no_kip" maxlength="50"
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
                <div>
                    <label class="block mb-1 font-medium text-gray-700">Nama KIP (Opsional)</label>
                    <input type="text" name="nama_kip" maxlength="255"
                        class="w-full p-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400" />
                </div>
            </div>

            <div class="mt-8 text-center">
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg shadow-md transition-all duration-200">Daftar</button>
            </div>
        </form>
    </div>
</body>

</html>