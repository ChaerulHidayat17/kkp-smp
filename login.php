<?php
session_start();
require 'config.php'; // File koneksi database

// Cek jika admin sudah login
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: daftar/view.php");
    exit();
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query cek admin di database
    $sql = "SELECT * FROM admin WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $admin = $result->fetch_assoc();

    // Validasi password
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $admin['username'];
        echo "<script>
                setTimeout(() => { window.location.href = 'daftar/view.php'; }, 1500);
                Swal.fire('Login Berhasil!', 'Selamat datang, admin!', 'success');
              </script>";
    } else {
        echo "<script>Swal.fire('Gagal!', 'Username atau password salah!', 'error');</script>";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(135deg, #667eea, #764ba2);
            animation: bgAnimation 6s infinite alternate;
        }

        @keyframes bgAnimation {
            0% { background-position: 0% 50%; }
            100% { background-position: 100% 50%; }
        }

        .login-card {
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm login-card">
        <h2 class="text-2xl font-bold text-center mb-6 text-gray-800">🔒 Admin Login</h2>
        
        <form method="POST">
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Username</label>
                <input type="text" name="username" required
                       class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold">Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500 transition">
            </div>
            <button type="submit"
                    class="w-full bg-purple-600 text-white py-2 rounded-lg hover:bg-purple-700 transition shadow-md">
                Login
            </button>
        </form>
    </div>

</body>
</html>
