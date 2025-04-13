<?php
include '../config.php'; // Pastikan file koneksi ke database sudah ada

// Ambil ID dari URL
$id = $_GET['id'];

// Ambil data berdasarkan ID
$query = $conn->prepare("SELECT * FROM peserta_didik WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();
$data = $result->fetch_assoc();

// Proses update data
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
    $alamat = $_POST['alamat'];
    $kelurahan = $_POST['kelurahan'];
    $kecamatan = $_POST['kecamatan'];
    $kabupaten = $_POST['kabupaten'];
    $provinsi = $_POST['provinsi'];
    $kode_pos = $_POST['kode_pos'];
    $alat_transportasi = $_POST['alat_transportasi'];
    $no_hp = $_POST['no_hp'];
    $no_kip = $_POST['no_kip'];
    $nama_kip = $_POST['nama_kip'];

    $update = $conn->prepare("UPDATE peserta_didik SET 
        nama_lengkap=?, jenis_kelamin=?, nisn=?, no_ijazah=?, no_ujian=?, no_kk=?, nik=?, 
        sekolah_asal=?, tempat_lahir=?, tanggal_lahir=?, agama=?, alamat=?, kelurahan=?, 
        kecamatan=?, kabupaten=?, provinsi=?, kode_pos=?, alat_transportasi=?, 
        no_hp=?, no_kip=?, nama_kip=? WHERE id=?");

    $update->bind_param("sssssssssssssssssssssi", $nama_lengkap, $jenis_kelamin, $nisn, $no_ijazah, $no_ujian, 
        $no_kk, $nik, $sekolah_asal, $tempat_lahir, $tanggal_lahir, $agama, $alamat, $kelurahan, 
        $kecamatan, $kabupaten, $provinsi, $kode_pos, $alat_transportasi, 
        $no_hp, $no_kip, $nama_kip, $id);

    if ($update->execute()) {
        echo "<script>alert('Data berhasil diperbarui'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui data');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Peserta Didik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="w-full max-w-3xl bg-white p-8 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-center mb-6">Edit Data Peserta Didik</h2>
        <form action="" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="<?= $data['nama_lengkap'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full p-2 border rounded">
                    <option value="Laki-laki" <?= ($data['jenis_kelamin'] == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                    <option value="Perempuan" <?= ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                </select>
            </div>
            
            <div>
    <label class="block text-gray-700">Agama</label>
    <select name="agama" class="w-full p-2 border rounded" required>
        <option value="Islam" <?= ($data['agama'] == 'Islam') ? 'selected' : '' ?>>Islam</option>
        <option value="Kristen" <?= ($data['agama'] == 'Kristen') ? 'selected' : '' ?>>Kristen</option>
        <option value="Katolik" <?= ($data['agama'] == 'Katolik') ? 'selected' : '' ?>>Katolik</option>
        <option value="Hindu" <?= ($data['agama'] == 'Hindu') ? 'selected' : '' ?>>Hindu</option>
        <option value="Buddha" <?= ($data['agama'] == 'Buddha') ? 'selected' : '' ?>>Buddha</option>
        <option value="Konghucu" <?= ($data['agama'] == 'Konghucu') ? 'selected' : '' ?>>Konghucu</option>
    </select>
</div>

            <div>
                <label class="block text-gray-700">NISN</label>
                <input type="text" name="nisn" value="<?= $data['nisn'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">No Ijazah</label>
                <input type="text" name="no_ijazah" value="<?= $data['no_ijazah'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">No Ujian</label>
                <input type="text" name="no_ujian" value="<?= $data['no_ujian'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">No KK</label>
                <input type="text" name="no_kk" value="<?= $data['no_kk'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">NIK</label>
                <input type="text" name="nik" value="<?= $data['nik'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">Sekolah Asal</label>
                <input type="text" name="sekolah_asal" value="<?= $data['sekolah_asal'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">Tempat Lahir</label>
                <input type="text" name="tempat_lahir" value="<?= $data['tempat_lahir'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" value="<?= $data['tanggal_lahir'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div class="col-span-2">
                <label class="block text-gray-700">Alamat</label>
                <textarea name="alamat" class="w-full p-2 border rounded"><?= $data['alamat'] ?></textarea>
            </div>
            
            <div>
                <label class="block text-gray-700">Kelurahan</label>
                <input type="text" name="kelurahan" value="<?= $data['kelurahan'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">Kecamatan</label>
                <input type="text" name="kecamatan" value="<?= $data['kecamatan'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">Kabupaten</label>
                <input type="text" name="kabupaten" value="<?= $data['kabupaten'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">Provinsi</label>
                <input type="text" name="provinsi" value="<?= $data['provinsi'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">Kode Pos</label>
                <input type="text" name="kode_pos" value="<?= $data['kode_pos'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">Alat Transportasi</label>
                <input type="text" name="alat_transportasi" value="<?= $data['alat_transportasi'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">No HP</label>
                <input type="text" name="no_hp" value="<?= $data['no_hp'] ?>" class="w-full p-2 border rounded" required>
            </div>
            
            <div>
                <label class="block text-gray-700">No KIP</label>
                <input type="text" name="no_kip" value="<?= $data['no_kip'] ?>" class="w-full p-2 border rounded">
            </div>
            
            <div>
                <label class="block text-gray-700">Nama KIP</label>
                <input type="text" name="nama_kip" value="<?= $data['nama_kip'] ?>" class="w-full p-2 border rounded">
            </div>
            
            <div class="col-span-2 flex justify-end">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>
