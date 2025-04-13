<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PPDB - Neumorphism</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Menambahkan Font Awesome untuk Ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
    .bg-school {
        background: url('gambar/pp_smp.png') no-repeat center center/cover;
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: -1;
    }

    body {
        background-color: #e0e5ec;
        transition: background-color 0.3s ease;
    }

    .neumorph {
        background: #e0e5ec;
        box-shadow: 9px 9px 16px #a3b1c6, -9px -9px 16px #ffffff;
        transition: all 0.3s ease;
    }

    .neumorph-inset {
        background: #e0e5ec;
        box-shadow: inset 6px 6px 10px #babecc, inset -6px -6px 10px #ffffff;
    }

    .soft-btn {
        background: #e0e5ec;
        box-shadow: 4px 4px 8px #babecc, -4px -4px 8px #ffffff;
        transition: all 0.2s ease-in-out;
    }

    .soft-btn:hover {
        box-shadow: inset 4px 4px 8px #babecc, inset -4px -4px 8px #ffffff;
    }

    .bg-overlay {
        background-color: rgba(255, 255, 255, 0.7);
        backdrop-filter: blur(10px);
    }

    /* Dark Mode Styles */
    .dark-mode {
        background-color: #1e293b;
        color: #f1f5f9;
    }

    .dark-mode .neumorph {
        background: #1e293b;
        box-shadow: 9px 9px 16px #1c2d42, -9px -9px 16px #3b4b67;
    }

    .dark-mode .neumorph-inset {
        background: #1e293b;
        box-shadow: inset 6px 6px 10px #3b4b67, inset -6px -6px 10px #1c2d42;
    }

    .dark-mode .soft-btn {
        background: #1e293b;
        box-shadow: 4px 4px 8px #3b4b67, -4px -4px 8px #1c2d42;
    }

    .dark-mode .soft-btn:hover {
        box-shadow: inset 4px 4px 8px #3b4b67, inset -4px -4px 8px #1c2d42;
    }

    .dark-mode .bg-overlay {
        background-color: rgba(31, 41, 55, 0.7);
        backdrop-filter: blur(10px);
    }

    /* Menambahkan perubahan warna teks untuk kontras lebih baik di mode gelap */
    .dark-mode .text-gray-700 {
        color: #f1f5f9;
    }

    .dark-mode .text-gray-600 {
        color: #e2e8f0;
    }

    .dark-mode .text-gray-500 {
        color: #cbd5e1;
    }

    .dark-mode .text-sm {
        color: #d1d5db;
    }

    /* Toggle button */
    .toggle-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        background-color: #f1f5f9;
        color: #1e293b;
        padding: 10px 15px;
        border-radius: 9999px;
        box-shadow: 4px 4px 8px #babecc, -4px -4px 8px #ffffff;
        transition: all 0.2s ease;
        cursor: pointer;
        font-size: 18px;
        z-index: 1000;
        /* Pastikan tombol berada di atas elemen lainnya */
    }

    .toggle-btn:hover {
        box-shadow: inset 4px 4px 8px #babecc, inset -4px -4px 8px #ffffff;
    }

    /* Responsif untuk tampilan mobile */
    @media (max-width: 768px) {
        .toggle-btn {
            top: 20px;
            right: 20px;
        }
    }
    </style>
</head>

<body class="flex flex-col items-center justify-center min-h-screen relative px-4">

    <!-- Background Sekolah -->
    <div class="bg-school"></div>

    <!-- Tombol Switch Mode -->
    <button id="darkModeToggle" class="toggle-btn">
        <i class="fas fa-moon"></i>
    </button>

    <!-- Konten utama -->
    <div class="relative text-center px-6 py-10 w-full max-w-2xl rounded-2xl bg-overlay neumorph z-10">
        <img src="gambar/pp.png" alt="Logo Sekolah" class="w-32 h-32 mx-auto rounded-full neumorph-inset">
        <h1 class="text-3xl font-bold mt-6 text-gray-700">Selamat Datang Di</h1>
        <h1 class="text-2xl font-bold text-gray-600">Sistem Informasi Sekolah</h1>
        <h1 class="text-xl font-semibold mb-4 text-gray-500">SMP Islam Terpadu Bahrul Ulum Sukakarya</h1>
        <p class="text-sm italic text-gray-600 mb-6 px-4">
            "Sistem informasi sekolah ini dirancang untuk memudahkan akses data akademik, pendaftaran siswa baru, dan
            pengelolaan nilai secara digital."
        </p>

        <!-- Tombol Navigasi -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
            <a href="daftar/index.php" class="soft-btn rounded-xl text-gray-700 font-semibold px-4 py-2">SPMB</a>
            <a href="data_nilai/nilai.php" class="soft-btn rounded-xl text-gray-700 font-semibold px-4 py-2">Data
                Nilai</a>
            <a href="data_akademik/akademik.php" class="soft-btn rounded-xl text-gray-700 font-semibold px-4 py-2">Data
                Akademik</a>
            <a href="admin/dashboard.php" class="soft-btn rounded-xl text-gray-700 font-semibold px-4 py-2">Admin</a>
        </div>

        <!-- Alamat & Email Sekolah -->
        <div class="mt-8 text-gray-600 text-sm leading-relaxed px-4">
            <p class="text-lg font-semibold text-gray-700">Alamat:</p>
            <p>Jl. Raya H. Bonin, Kp. Gili-Gili RT.01/05 Ds. Suakajadi Kec. Sukakarya Kab. Bekasi 17630</p>
            <p class="mt-4 text-lg font-semibold text-gray-700">Email:</p>
            <p>smpibahrululumgili02@gmail.com</p>
        </div>
    </div>

    <!-- Footer -->
    <footer class="relative text-gray-600 text-center w-full py-4 mt-6 text-sm z-10">
        <p>&copy; 2025 SMP Islam Terpadu Bahrul Ulum</p>
    </footer>

    <script>
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;

    darkModeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        // Mengubah ikon berdasarkan mode aktif
        const icon = body.classList.contains('dark-mode') ? 'fa-sun' : 'fa-moon';
        darkModeToggle.innerHTML = `<i class="fas ${icon}"></i>`;
    });
    </script>
</body>

</html>