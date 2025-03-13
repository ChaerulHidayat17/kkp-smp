<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Penerimaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/scrollreveal/4.0.9/scrollreveal.min.js"></script>
</head>
<body class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400 flex items-center justify-center min-h-screen p-4 text-white text-center">
    <div class="p-8 rounded-lg shadow-2xl bg-white bg-opacity-90 backdrop-blur-lg w-full max-w-2xl border border-gray-300 relative overflow-hidden text-gray-900">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-4 text-blue-700 animate-bounce">🎉 SELAMAT! 🎉</h1>
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">ANDA DITERIMA DI</h2>
        <h2 class="text-2xl md:text-3xl font-extrabold text-blue-800 mt-2">SMP ISLAM TERPADU BAHRUL ULUM GILI GILI</h2>
        <p class="mt-6 text-xl md:text-2xl font-bold text-green-600 animate-pulse">GRATIS!!! Semua Biaya Pendidikan Ditanggung!</p>
        <ul class="mt-4 text-lg md:text-xl font-semibold space-y-3">
            <li class="bg-green-200 p-2 rounded-lg text-green-900">✅ Uang Pendaftaran</li>
            <li class="bg-green-200 p-2 rounded-lg text-green-900">✅ Uang Bangunan</li>
            <li class="bg-green-200 p-2 rounded-lg text-green-900">✅ Uang Bulanan / SPP</li>
            <li class="bg-green-200 p-2 rounded-lg text-green-900">✅ Seragam Sekolah</li>
        </ul>
        <button onclick="togglePopup()" class="mt-6 px-8 py-4 bg-blue-600 text-white font-bold rounded-full shadow-lg hover:bg-blue-700 transition-transform transform hover:scale-105 cursor-pointer">Info Lebih Lanjut</button>
    </div>
    
    <!-- Pop-up Box -->
    <div id="popupBox" class="hidden fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50 backdrop-blur-sm">
        <div class="bg-white p-6 rounded-lg shadow-2xl w-96 text-center border border-gray-300">
            <h2 class="text-2xl font-extrabold mb-4 text-blue-700">📞 Contact Person</h2>
            <div class="space-y-3">
                <div class="bg-blue-100 p-3 rounded-lg shadow-md">
                    <p class="text-lg font-semibold text-gray-900">H. Nur Ali, S.Pd.I</p>
                    <p class="text-blue-600 font-bold">085781965566</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg shadow-md">
                    <p class="text-lg font-semibold text-gray-900">Ust. Eman Sulaeman, S.Pd.I</p>
                    <p class="text-blue-600 font-bold">085772377753</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg shadow-md">
                    <p class="text-lg font-semibold text-gray-900">M. Ishak, S.Pd.I</p>
                    <p class="text-blue-600 font-bold">085772729578</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg shadow-md">
                    <p class="text-lg font-semibold text-gray-900">Karman, S.Pd</p>
                    <p class="text-blue-600 font-bold">085694112206</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg shadow-md">
                    <p class="text-lg font-semibold text-gray-900">A. Agung S, S.Kom</p>
                    <p class="text-blue-600 font-bold">0857770159151</p>
                </div>
                <div class="bg-blue-100 p-3 rounded-lg shadow-md">
                    <p class="text-lg font-semibold text-gray-900">Ridzky W. F, S.SI</p>
                    <p class="text-blue-600 font-bold">083140395930</p>
                </div>
            </div>
            <div class="flex justify-center mt-6">
                <button onclick="togglePopup()" class="bg-red-500 text-white px-6 py-3 rounded-full font-bold hover:bg-red-600 transition">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function togglePopup() {
            const popup = document.getElementById("popupBox");
            popup.classList.toggle("hidden");
        }
    </script>
</body>
</html>
