<?php

// Parameter koneksi ke database
$hostname = "localhost";
$username = "root";
$password = "";
$database = "ppdb_online";

// Membuat koneksi ke database
$conn = new mysqli($hostname, $username, $password, $database);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil nomor telepon dari database
$sql = "SELECT no_hp FROM peserta_didik"; // Gantilah "hp" sesuai dengan nama kolom di database
$result = $conn->query($sql);

// Memeriksa apakah query berhasil
if ($result) {
    $nomorTelepon = [];

    // Mengambil nomor telepon dan menambahkannya ke dalam array
    while ($row = $result->fetch_assoc()) {
        $nomorTelepon[] = $row['no_hp'];
    }

    // Tutup koneksi database
    $conn->close();

    if (!empty($nomorTelepon)) {
        // API Fonnte
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target' => implode(',', $nomorTelepon), // Menggabungkan semua nomor
                'message' => 'Pengumuman Penting: 
                
                Program PPDB online telah dibuka. Silakan segera daftar di website resmi kami.',
                'delay' => 10, // Delay dalam detik
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: jxq8cXNoxsXgA7qnGyaN' // Gantilah dengan API Key Fonnte kamu
            ],
        ]);

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            echo "cURL Error: " . curl_error($curl);
        } else {
            echo "Pesan berhasil dikirim: " . $response;
        }

        curl_close($curl);
    } else {
        echo "Tidak ada nomor HP yang ditemukan.";
    }
} else {
    echo "Error dalam query database: " . $conn->error;
}

?>
