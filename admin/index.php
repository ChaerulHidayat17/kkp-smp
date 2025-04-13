<?php
session_start();
require 'config.php'; // File koneksi database

$success = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Query cek admin di database
        $sql = "SELECT * FROM admin WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $admin = $result->fetch_assoc();

        // Validasi password
        if ($admin && password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $admin['username'];
            $success = true; // Tandai login berhasil
        } else {
            $error = "Username atau password salah!";
        }
    } else {
        $error = "Harap isi username dan password!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100 relative">

    <div class="bg-white p-6 rounded-lg shadow-md w-full max-w-sm relative">
        <h2 class="text-2xl font-bold text-center mb-4">Login Admin</h2>
        
        <!-- Pop-up Box Login Gagal -->
        <?php if (!empty($error)): ?>
        <div id="error-popup" class="fixed top-10 left-1/2 transform -translate-x-1/2 bg-red-500 text-white p-4 rounded-lg shadow-lg w-96 opacity-0 transition-opacity duration-500 ease-in-out z-50">
            <p class="text-center"><?= htmlspecialchars($error); ?></p>
            <button onclick="closePopup('error-popup')" class="absolute top-0 right-0 m-2 text-lg font-bold">&times;</button>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(() => {
                    let popup = document.getElementById("error-popup");
                    popup.style.opacity = "1"; // Efek fade-in
                    popup.classList.add("animate-bounce"); // Efek animasi
                }, 200);
            });

            function closePopup(id) {
                let popup = document.getElementById(id);
                popup.style.opacity = "0"; // Efek fade-out
                setTimeout(() => popup.style.display = "none", 500);
            }
        </script>
        <?php endif; ?>

        <!-- Pop-up Box Login Berhasil -->
        <?php if ($success): ?>
        <div id="success-popup" class="fixed top-10 left-1/2 transform -translate-x-1/2 bg-green-500 text-white p-4 rounded-lg shadow-lg w-96 opacity-0 transition-opacity duration-500 ease-in-out z-50">
            <p class="text-center">Login Berhasil! 🎉</p>
            <button onclick="closePopup('success-popup')" class="absolute top-0 right-0 m-2 text-lg font-bold">&times;</button>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(() => {
                    let popup = document.getElementById("success-popup");
                    popup.style.opacity = "1"; // Efek fade-in
                    popup.classList.add("animate-bounce"); // Efek animasi
                }, 200);

                // Redirect setelah 2 detik
                setTimeout(() => {
                    window.location.href = "daftar/view.php";
                }, 2000);
            });
        </script>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700">Username</label>
                <input type="text" name="username" required class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Password</label>
                <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:ring focus:ring-blue-300">
            </div>
            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded-lg hover:bg-blue-600">Login</button>
        </form>
    </div>

</body>
</html>
