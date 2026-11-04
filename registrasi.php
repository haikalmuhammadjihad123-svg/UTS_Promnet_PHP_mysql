<?php
session_start();

// Jika sudah login, tidak perlu registrasi lagi
if (isset($_SESSION['session_login'])) {
    header('Location: index.php');
    exit;
}

require 'function.php';

// Cek apakah tombol register ditekan
if (isset($_POST['register'])) {
    if (registrasi($_POST) > 0) {
        echo "<script>
            alert('Registrasi akun admin berhasil! Silakan login.');
            document.location.href = 'login.php';
        </script>";
    } else {
        echo "<script>
            alert('Registrasi akun admin gagal!');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Admin Kosan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm mt-4">
                    <div class="card-header bg-dark text-white text-center py-3">
                        <h4 class="mb-0">📝 Registrasi Admin Baru</h4>
                    </div>
                    <div class="card-body p-4">

                        <form action="" method="post">
                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Buat username" required autocomplete="off">
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Buat password" required>
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-3">
                                <label for="konfirmasi_password" class="form-label">Konfirmasi Password</label>
                                <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" placeholder="Ulangi password" required>
                            </div>

                            <!-- Tombol Register -->
                            <button type="submit" name="register" class="btn btn-success w-100 py-2 mt-2">Daftar Admin</button>

                            <!-- Link ke Login -->
                            <div class="text-center mt-3">
                                <small>Sudah punya akun? <a href="login.php">Login di sini</a></small>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>