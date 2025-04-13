<?php
session_start();
require '../config.php'; // File koneksi database

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
    <title>Login Admin - Neumorphism UI</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
    body {
        background-color: #e0e5ec;
    }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen">

    <div class="bg-gray-100 p-10 rounded-3xl shadow-[8px_8px_16px_#c5c9d4,-8px_-8px_16px_#ffffff] w-full max-w-md">

        <h2 class="text-3xl font-bold text-center text-gray-700 mb-8 drop-shadow-sm">Login Admin</h2>

        <!-- Pop-up Box Login Gagal -->
        <?php if (!empty($error)): ?>
        <div id="error-popup" class="bg-red-200 text-red-800 p-4 rounded-xl shadow-inner text-center mb-4">
            <p><?= htmlspecialchars($error); ?></p>
        </div>
        <script>
        setTimeout(() => document.getElementById("error-popup").style.display = "none", 3000);
        </script>
        <?php endif; ?>

        <!-- Pop-up Box Login Berhasil -->
        <?php if ($success): ?>
        <div id="success-popup" class="bg-green-200 text-green-800 p-4 rounded-xl shadow-inner text-center mb-4">
            <p>Login Berhasil! 🎉</p>
        </div>
        <script>
        setTimeout(() => {
            window.location.href = "dashboard.php";
        }, 2000);
        </script>
        <?php endif; ?>

        <form method="POST" class="space-y-6">
            <div>
                <label class="block text-gray-600 font-medium mb-1">Username</label>
                <input type="text" name="username" required
                    class="w-full px-4 py-3 rounded-xl bg-gray-100 shadow-inner focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <div>
                <label class="block text-gray-600 font-medium mb-1">Password</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-3 rounded-xl bg-gray-100 shadow-inner focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit"
                class="w-full py-3 rounded-xl bg-gray-100 shadow-[4px_4px_8px_#c5c9d4,-4px_-4px_8px_#ffffff] text-gray-700 font-semibold hover:text-blue-600 transition-all duration-200">
                Login
            </button>
        </form>

        <p class="text-center text-gray-500 text-sm mt-6">© <?= date('Y'); ?> PPDB Online</p>
    </div>

</body>

</html>