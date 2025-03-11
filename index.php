<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard PPDB</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Background dengan gambar sekolah + blur */
        .bg-school {
            background: url('sekolah.jpg') no-repeat center center/cover;
            filter: blur(8px);
            position: fixed;
            width: 100%;
            height: 100%;
            z-index: -1;
        }
    </style>
</head>
<body class="flex flex-col items-center justify-center min-h-screen relative px-4">
    
    <!-- Background Blur -->
    <div class="bg-school"></div>

    <!-- Overlay untuk memperjelas teks -->
    <div class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-md"></div>

    <!-- Konten -->
    <div class="relative text-center text-white px-4 pb-20"> 
        <img src="1.png" alt="Logo Sekolah" class="w-48 h-48 mx-auto">
        <h1 class="text-2xl font-bold mt-4 text-white-300">Selamat Datang Di</h1>
        <h1 class="text-2xl font-bold text-white-300">Sistem Informasi Sekolah</h1>
        <h1 class="text-2xl font-bold text-white-300">SMP Islam Terpadu Bahrul Ulum</h1>

        <!-- Tombol Navigasi -->
        <div class="mt-6 flex flex-col md:flex-row gap-3 justify-center items-center">
            <a href="spmb/pendaftaran.php" class="bg-green-600 text-white px-6 py-3 rounded-lg shadow-md w-full md:w-auto text-center hover:bg-green-700 transition">
                SPMB
            </a>
            <a href="nilai/data_nilai.php" class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow-md w-full md:w-auto text-center hover:bg-blue-700 transition">
                Data Nilai
            </a>
            <a href="data/data_akademik.php" class="bg-red-600 text-white px-6 py-3 rounded-lg shadow-md w-full md:w-auto text-center hover:bg-red-700 transition">
                Data Akademik
            </a>
        </div>

       <!-- Alamat & Email Sekolah -->
<div class="mt-6 text-gray-300 max-w-md mx-auto text-center leading-relaxed">
    <p class="text-lg font-semibold">Alamat:</p>
    <p>Jl. Raya H. Bonin, Kp. Gili-Gili RT.01/05 Ds. Suakajadi Kec. Sukakarya Kab. Bekasi 17630</p>
    
    <p class="mt-2 text-lg font-semibold">Email:</p>
    <p>smpibahrululumgili02@gmail.com</p>
</div>


    <!-- Footer -->
    <footer class="relative text-white text-center w-full py-4">
        <p>&copy; 2025 SMP Islam Terpadu Bahrul Ulum</p>
    </footer>

</body>
</html>
