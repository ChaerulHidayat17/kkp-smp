<?php
include 'config.php';
$query = "SELECT * FROM peserta_didik";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta Didik</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto">
        <h2 class="text-2xl font-bold mb-4">Data Peserta Didik</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-blue-500 text-white">
                    <tr>
                        <th class="p-3 text-center">No</th>
                        <th class="p-3 text-left">Nama Lengkap</th>
                        <th class="p-3 text-center">NISN</th>
                        <th class="p-3 text-center">Jenis Kelamin</th>
                        <th class="p-3 text-center">Agama</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr class="border-b">
                        <td class="p-3 text-center"><?= $no++; ?></td>
                        <td class="p-3"><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                        <td class="p-3 text-center"><?= htmlspecialchars($row['nisn']); ?></td>
                        <td class="p-3 text-center"><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                        <td class="p-3 text-center"><?= htmlspecialchars($row['agama']); ?></td>
                        <td class="p-3 text-center">
                            <button onclick="openModal(<?= $row['id']; ?>)" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-700">
                                Detail
                            </button>
                        </td>
                    </tr>

                    <!-- Modal Detail -->
                    <div id="modal-<?= $row['id']; ?>" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden flex items-center justify-center">
                        <div class="bg-white p-6 rounded-lg w-11/12 md:w-1/2">
                            <h3 class="text-xl font-bold mb-4">Detail Peserta</h3>
                            <div class="grid grid-cols-2 gap-4">
                                <p><strong>Nama:</strong> <?= htmlspecialchars($row['nama_lengkap']); ?></p>
                                <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($row['jenis_kelamin']); ?></p>
                                <p><strong>NISN:</strong> <?= htmlspecialchars($row['nisn']); ?></p>
                                <p><strong>No Ijazah:</strong> <?= htmlspecialchars($row['no_ijazah']); ?></p>
                                <p><strong>No Ujian:</strong> <?= htmlspecialchars($row['no_ujian']); ?></p>
                                <p><strong>No KK:</strong> <?= htmlspecialchars($row['no_kk']); ?></p>
                                <p><strong>NIK:</strong> <?= htmlspecialchars($row['nik']); ?></p>
                                <p><strong>Sekolah Asal:</strong> <?= htmlspecialchars($row['sekolah_asal']); ?></p>
                                <p><strong>Tempat, Tanggal Lahir:</strong> <?= htmlspecialchars($row['tempat_lahir'] . ', ' . $row['tanggal_lahir']); ?></p>
                                <p><strong>Agama:</strong> <?= htmlspecialchars($row['agama']); ?></p>
                                <p><strong>Alamat:</strong> <?= htmlspecialchars($row['alamat']); ?></p>
                                <p><strong>Kelurahan:</strong> <?= htmlspecialchars($row['kelurahan']); ?></p>
                                <p><strong>Kecamatan:</strong> <?= htmlspecialchars($row['kecamatan']); ?></p>
                                <p><strong>Kabupaten:</strong> <?= htmlspecialchars($row['kabupaten']); ?></p>
                                <p><strong>Provinsi:</strong> <?= htmlspecialchars($row['provinsi']); ?></p>
                                <p><strong>Kode Pos:</strong> <?= htmlspecialchars($row['kode_pos']); ?></p>
                                <p><strong>Alat Transportasi:</strong> <?= htmlspecialchars($row['alat_transportasi']); ?></p>
                                <p><strong>No HP:</strong> <?= htmlspecialchars($row['no_hp']); ?></p>
                                <p><strong>No KIP:</strong> <?= htmlspecialchars($row['no_kip']); ?></p>
                                <p><strong>Nama KIP:</strong> <?= htmlspecialchars($row['nama_kip']); ?></p>
                            </div>
                            
                            <div class="flex justify-between mt-4">
    <a href="export_pdf.php?id=<?= $row['id']; ?>" target="_blank" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">
        Download PDF
    </a>
    
    <button onclick="closeModal(<?= $row['id']; ?>)" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">
        Tutup
    </button>
    
    <a href="export_excel.php?id=<?= $row['id']; ?>" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-700">
        Donwload Excel
    </a>
</div>

                        </div>
                    </div>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById("modal-" + id).classList.remove("hidden");
        }
        function closeModal(id) {
            document.getElementById("modal-" + id).classList.add("hidden");
        }
    </script>
</body>
</html>
