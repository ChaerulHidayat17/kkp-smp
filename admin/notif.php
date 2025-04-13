<?php
session_start();
include '../config.php'; // Koneksi ke database

// Cek apakah admin sudah login
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$success = false;
$error = "";

// Cek apakah request menggunakan metode POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $message = trim($_POST["message"] ?? '');

    if (empty($message)) {
        $error = "Pesan tidak boleh kosong!";
    } else {
        // Ambil data peserta didik yang memiliki nomor HP
        $query = "SELECT nama_lengkap, no_hp FROM peserta_didik WHERE no_hp IS NOT NULL AND no_hp != ''";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            $error = "Gagal mengambil data peserta.";
        } else {
            $targets = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $nomor_hp = trim(preg_replace('/[^0-9]/', '', $row['no_hp'])); // Hapus karakter non-numerik
                if (substr($nomor_hp, 0, 1) === "0") {
                    $nomor_hp = "62" . substr($nomor_hp, 1); // Ubah 08xxx menjadi 62xxx
                }
                if (!empty($nomor_hp)) {
                    $targets[] = "{$nomor_hp}|{$row['nama_lengkap']}|Peserta";
                }
            }

            if (empty($targets)) {
                $error = "Tidak ada nomor HP yang tersedia untuk dikirim.";
            } else {
                $targetString = implode(',', $targets);

                // Kirim pesan menggunakan API Fonnte
                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.fonnte.com/send',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array(
                        'target' => $targetString,
                        'message' => $message,
                        'typing' => false,
                        'delay' => '2',
                        'countryCode' => '62',
                    ),
                    CURLOPT_HTTPHEADER => array(
                        'Authorization: jxq8cXNoxsXgA7qnGyaN' // Ganti dengan token API Fonnte Anda
                    ),
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_SSL_VERIFYHOST => false,
                ));

                $response = curl_exec($curl);

                if (curl_errno($curl)) {
                    $error = "Error: " . curl_error($curl);
                } else {
                    $responseData = json_decode($response, true);
                    if (!empty($responseData['status']) && $responseData['status'] == true) {
                        $success = true;
                        // Redirect otomatis ke dashboard setelah berhasil
                        echo "<script>alert('✅ Pesan berhasil dikirim!'); window.location.href = 'dashboard.php';</script>";
                        exit;
                    } else {
                        $error = "Gagal mengirim pesan.";
                    }
                }
                curl_close($curl);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirim Pesan WhatsApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    /* Neumorphism effect */
    .neumorph {
        background: #e0e5ec;
        border-radius: 10px;
        box-shadow: 8px 8px 15px rgba(0, 0, 0, 0.1), -8px -8px 15px rgba(255, 255, 255, 0.7);
    }

    .neumorph-input {
        background: #e0e5ec;
        border-radius: 10px;
        border: none;
        padding: 12px;
        width: 100%;
        box-shadow: inset 4px 4px 6px rgba(0, 0, 0, 0.1), inset -4px -4px 6px rgba(255, 255, 255, 0.7);
    }

    .neumorph-button {
        background: #e0e5ec;
        border-radius: 10px;
        border: none;
        padding: 12px;
        width: 100%;
        box-shadow: 8px 8px 15px rgba(0, 0, 0, 0.1), -8px -8px 15px rgba(255, 255, 255, 0.7);
        color: #2d2d2d;
        font-weight: bold;
        transition: 0.3s;
    }

    .neumorph-button:hover {
        background: #d0d8e0;
        box-shadow: 8px 8px 15px rgba(0, 0, 0, 0.1), -8px -8px 15px rgba(255, 255, 255, 0.8);
    }

    .neumorph-button:active {
        background: #c0c8d0;
        box-shadow: inset 4px 4px 6px rgba(0, 0, 0, 0.1), inset -4px -4px 6px rgba(255, 255, 255, 0.7);
    }
    </style>
</head>

<body class="bg-gray-200 flex items-center justify-center h-screen">

    <div class="neumorph p-8 w-full max-w-lg">
        <h2 class="text-2xl font-bold mb-4 text-center text-blue-700">Kirim Pesan WhatsApp</h2>

        <?php if (!empty($error)): ?>
        <div id="popup" class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center">
            <div class="neumorph p-6 text-center">
                <p class="text-red-700 font-semibold">❌ <?= $error; ?></p>
                <button onclick="closePopup()" class="neumorph-button mt-4">Tutup</button>
            </div>
        </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <label for="message" class="block text-gray-700 font-medium">Pesan:</label>
                <textarea id="message" name="message" rows="4"
                    class="neumorph-input mt-1 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <button type="submit" class="neumorph-button">🚀 Kirim Pesan</button>
        </form>
    </div>

    <script>
    function closePopup() {
        var popup = document.getElementById('popup');
        if (popup) {
            popup.style.display = 'none';
        }
    }
    </script>

</body>

</html>