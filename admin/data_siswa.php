<?php
session_start();
include '../config.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Query untuk mengambil data peserta didik
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-gray-100">

    <div class="p-4">
        <input type="text" id="search" placeholder="Cari nama peserta..."
            class="w-full p-2 mb-4 border border-gray-300 rounded-lg">
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
            <thead class="bg-blue-500 text-white">
                <tr>
                    <th class="p-3 text-center">No</th>
                    <th class="p-3 text-left">Nama Lengkap</th>
                    <th class="p-3 text-center">NISN</th>
                    <th class="p-3 text-center">Jenis Kelamin</th>
                    <th class="p-3 text-center">Tanggal Lahir</th>
                    <th class="p-3 text-center">Alamat</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody id="table-body" class="text-gray-700">
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr class="border-b">
                    <td class="p-3 text-center"><?= $no++; ?></td>
                    <td class="p-3 participant-name"><?= htmlspecialchars($row['nama_lengkap']); ?></td>
                    <td class="p-3 text-center"><?= htmlspecialchars($row['nisn']); ?></td>
                    <td class="p-3 text-center"><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                    <td class="p-3 text-center"><?= htmlspecialchars($row['tanggal_lahir']); ?></td>
                    <td class="p-3 text-center"><?= htmlspecialchars($row['alamat']); ?></td>
                    <td class="p-3 text-center">
                        <!-- Tombol Detail -->
                        <button onclick="openModal(<?= $row['id']; ?>)"
                            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-700">Detail</button>

                        <!-- Tombol Edit -->
                        <a href="edit.php?id=<?= $row['id']; ?>"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 ml-2">Edit</a>

                        <!-- Tombol Hapus -->
                        <button onclick="confirmDelete(<?= $row['id']; ?>)"
                            class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700 ml-2">Hapus</button>

                    </td>

                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php mysqli_data_seek($result, 0); // Reset hasil query untuk modal ?>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <div id="modal-<?= $row['id']; ?>"
        class="hidden fixed inset-0 bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <div
            style="background-color: #e0e5ec; padding: 24px; border-radius: 12px; box-shadow: 8px 8px 15px rgba(0, 0, 0, 0.1), -8px -8px 15px rgba(255, 255, 255, 0.7); width: 66%; max-width: 800px;">
            <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 16px; text-align: center; color: #4a4a4a;">
                Detail Peserta Didik</h2>
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                <p><strong>Nama Lengkap:</strong> <?= htmlspecialchars($row['nama_lengkap']); ?></p>
                <p><strong>Jenis Kelamin:</strong> <?= htmlspecialchars($row['jenis_kelamin']); ?></p>
                <p><strong>NISN:</strong> <?= htmlspecialchars($row['nisn']); ?></p>
                <p><strong>No Ijazah:</strong> <?= htmlspecialchars($row['no_ijazah']); ?></p>
                <p><strong>No Ujian:</strong> <?= htmlspecialchars($row['no_ujian']); ?></p>
                <p><strong>No KK:</strong> <?= htmlspecialchars($row['no_kk']); ?></p>
                <p><strong>NIK:</strong> <?= htmlspecialchars($row['nik']); ?></p>
                <p><strong>Asal Sekolah:</strong> <?= htmlspecialchars($row['sekolah_asal']); ?></p>
                <p><strong>Tempat Lahir:</strong> <?= htmlspecialchars($row['tempat_lahir']); ?></p>
                <p><strong>Tanggal Lahir:</strong> <?= htmlspecialchars($row['tanggal_lahir']); ?></p>
                <p><strong>Agama:</strong> <?= htmlspecialchars($row['agama']); ?></p>
                <p><strong>Alamat:</strong> <?= htmlspecialchars($row['alamat']); ?></p>
                <p><strong>Kelurahan:</strong> <?= htmlspecialchars($row['kelurahan']); ?></p>
                <p><strong>Kecamatan:</strong> <?= htmlspecialchars($row['kecamatan']); ?></p>
                <p><strong>Kabupaten:</strong> <?= htmlspecialchars($row['kabupaten']); ?></p>
                <p><strong>Provinsi:</strong> <?= htmlspecialchars($row['provinsi']); ?></p>
                <p><strong>Kode Pos:</strong> <?= htmlspecialchars($row['kode_pos']); ?></p>
                <p><strong>Alat Transportasi:</strong> <?= htmlspecialchars($row['alat_transportasi']); ?></p>
                <p><strong>No HP:</strong> <?= htmlspecialchars($row['no_hp']); ?></p>
                <p><strong>No KIP:</strong> <?= htmlspecialchars($row['no_kip'] ?: '-'); ?></p>
                <p><strong>Nama KIP:</strong> <?= htmlspecialchars($row['nama_kip'] ?: '-'); ?></p>
            </div>
            <div style="margin-top: 16px; display: flex; justify-content: space-between;">
                <a href="export_pdf.php?id=<?= $row['id']; ?>"
                    style="background-color: #4299e1; color: white; padding: 12px 24px; border-radius: 12px; box-shadow: 8px 8px 15px rgba(0, 0, 0, 0.1), -8px -8px 15px rgba(255, 255, 255, 0.7); transition: all 0.3s ease;"
                    onmouseover="this.style.backgroundColor='#3182ce'; this.style.boxShadow='8px 8px 20px rgba(0, 0, 0, 0.2), -8px -8px 20px rgba(255, 255, 255, 0.8)';"
                    onmouseout="this.style.backgroundColor='#4299e1'; this.style.boxShadow='8px 8px 15px rgba(0, 0, 0, 0.1), -8px -8px 15px rgba(255, 255, 255, 0.7)';">
                    Download PDF
                </a>
                <button onclick="closeModal(<?= $row['id']; ?>)"
                    style="background-color: #f56565; color: white; padding: 12px 24px; border-radius: 12px; box-shadow: 8px 8px 15px rgba(0, 0, 0, 0.1), -8px -8px 15px rgba(255, 255, 255, 0.7); transition: all 0.3s ease;"
                    onmouseover="this.style.backgroundColor='#e53e3e'; this.style.boxShadow='8px 8px 20px rgba(0, 0, 0, 0.2), -8px -8px 20px rgba(255, 255, 255, 0.8)';"
                    onmouseout="this.style.backgroundColor='#f56565'; this.style.boxShadow='8px 8px 15px rgba(0, 0, 0, 0.1), -8px -8px 15px rgba(255, 255, 255, 0.7)';">
                    Tutup
                </button>
            </div>
        </div>
    </div>
    <?php endwhile; ?>


    <script>
    function openModal(id) {
        document.getElementById("modal-" + id).classList.remove("hidden");
    }

    function closeModal(id) {
        document.getElementById("modal-" + id).classList.add("hidden");
    }
    document.getElementById("search").addEventListener("input", function() {
        let searchValue = this.value.toLowerCase();
        let rows = document.querySelectorAll("#table-body tr");
        rows.forEach(row => {
            let name = row.querySelector(".participant-name").textContent.toLowerCase();
            row.style.display = name.includes(searchValue) ? "table-row" : "none";
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "delete.php?id=" + id;
            }
        });
    }
    </script>

    </script>

</body>

</html>