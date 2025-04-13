<?php
session_start();
include '../config.php';

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Query untuk mendapatkan jumlah peserta didik
$query = "SELECT id FROM peserta_didik";
$result = mysqli_query($conn, $query);
$total_peserta = mysqli_num_rows($result);

// Ambil API Cuaca dari .env
$apiKey = getenv('WEATHER_API_KEY'); 
$city = "Sukakarya";

$temp = 'N/A';
$weather = 'Tidak tersedia';
$weather_icon = '02d';
$icon_url = "https://openweathermap.org/img/wn/{$weather_icon}@2x.png";

if ($apiKey) {
    $apiUrl = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric&lang=id";
    
    $weatherResponse = @file_get_contents($apiUrl);
    if ($weatherResponse) {
        $weatherData = json_decode($weatherResponse, true);
        $temp = $weatherData['main']['temp'] ?? 'N/A';
        $weather = ucfirst($weatherData['weather'][0]['description'] ?? 'N/A');
        $weather_icon = $weatherData['weather'][0]['icon'] ?? '02d';
        $icon_url = "https://openweathermap.org/img/wn/{$weather_icon}@2x.png";
    }
}

// Tentukan waktu saat ini
date_default_timezone_set('Asia/Jakarta'); 
$tanggal = date('l, d F Y'); // Format tanggal
$jam = date('H:i:s'); // Format jam
$greeting = (date('H') >= 5 && date('H') < 12) ? "Selamat Pagi" :
    ((date('H') >= 12 && date('H') < 15) ? "Selamat Siang" :
    ((date('H') >= 15 && date('H') < 18) ? "Selamat Sore" : "Selamat Malam"));
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Neumorphism UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    body {
        background-color: #e0e5ec;
    }
    </style>
</head>

<body class="flex">

    <!-- Sidebar -->
    <div class="w-64 min-h-screen p-6 bg-gray-100 shadow-[8px_8px_16px_#c5c9d4,-8px_-8px_16px_#ffffff] rounded-r-3xl">
        <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">SMPIT BAHRUL ULUM</h2>
        <ul class="space-y-4">
            <li><a href="#" id="loadDashboard"
                    class="block px-4 py-3 rounded-xl bg-gray-100 text-gray-700 shadow-[4px_4px_8px_#c5c9d4,-4px_-4px_8px_#ffffff] hover:text-blue-600 transition">🏠
                    Dashboard</a></li>
            <li><a href="#" id="loadDataSiswa"
                    class="block px-4 py-3 rounded-xl bg-gray-100 text-gray-700 shadow-[4px_4px_8px_#c5c9d4,-4px_-4px_8px_#ffffff] hover:text-blue-600 transition">📋
                    Data Peserta Didik</a></li>
            <li><a href="export_excel.php"
                    class="block px-4 py-3 rounded-xl bg-gray-100 text-gray-700 shadow-[4px_4px_8px_#c5c9d4,-4px_-4px_8px_#ffffff] hover:text-blue-600 transition">📂
                    Export Data</a></li>
            <li><a href="notif.php"
                    class="block px-4 py-3 rounded-xl bg-gray-100 text-gray-700 shadow-[4px_4px_8px_#c5c9d4,-4px_-4px_8px_#ffffff] hover:text-blue-600 transition">📞
                    Notifikasi WhatsApp</a></li>
            <li><a href="logout.php"
                    class="block px-4 py-3 rounded-xl bg-red-100 text-red-700 shadow-inner hover:bg-red-200 transition">🚪
                    Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8">
        <div class="bg-gray-100 p-6 rounded-3xl shadow-[inset_4px_4px_10px_#c5c9d4,inset_-4px_-4px_10px_#ffffff] mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <p class="text-xl font-semibold text-gray-700"><?= $greeting ?>, Admin!</p>
                    <p class="text-gray-500">📅 <span id="tanggal"><?= $tanggal ?></span> | 🕒 <span
                            id="jam"><?= $jam ?></span></p>
                    <p class="text-gray-500">🌤 Cuaca di <?= $city ?>: <span id="weather"><?= $weather ?></span>,
                        <span id="temp"><?= $temp ?></span>°C
                    </p>
                </div>
                <img id="weatherIcon" src="<?= $icon_url; ?>" alt="Weather Icon" class="w-16 h-16">
            </div>
        </div>

        <div id="content"
            class="bg-gray-100 p-6 rounded-3xl shadow-[inset_4px_4px_10px_#c5c9d4,inset_-4px_-4px_10px_#ffffff]">
            <!-- Konten dinamis akan dimuat di sini -->
        </div>
    </div>

    <script>
    function updateTime() {
        let now = new Date();
        let formattedTime = now.toLocaleTimeString('id-ID', {
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit'
        });
        document.getElementById("jam").textContent = formattedTime;
    }

    setInterval(updateTime, 1000);

    function updateWeather() {
        $.ajax({
            url: "weather_update.php",
            method: "GET",
            dataType: "json",
            success: function(response) {
                $("#weather").text(response.weather);
                $("#temp").text(response.temp);
                $("#weatherIcon").attr("src", "https://openweathermap.org/img/wn/" + response.icon +
                    "@2x.png");
            }
        });
    }

    setInterval(updateWeather, 600000);

    $(document).ready(function() {
        $("#loadDataSiswa").on("click", function(e) {
            e.preventDefault();
            $.ajax({
                url: "data_siswa.php",
                method: "GET",
                success: function(response) {
                    $("#content").html(response);
                }
            });
        });
    });
    </script>

</body>

</html>