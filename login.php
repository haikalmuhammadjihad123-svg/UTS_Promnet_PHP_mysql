<?php
session_start();

// Jika sudah login, langsung alihkan ke index.php
if (isset($_SESSION['session_login'])) {
    header('Location: index.php');
    exit;
}

require 'function.php';

// Cek apakah tombol login ditekan
if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");

    // Cek username
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);

        // Cek password menggunakan password_verify
        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['session_login'] = true;
            $_SESSION['username'] = $username;

            header('Location: index.php');
            exit;
        } else {
            echo "<script>
                alert('Password yang Anda masukkan salah!');
            </script>";
        }
    } else {
        echo "<script>
            alert('Username tidak ditemukan!');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin Kosan</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm mt-5">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0">🏠 Login Admin Kosan</h4>
                    </div>
                    <div class="card-body p-4">

                        <form action="" method="post">
                            <!-- Username -->
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required autocomplete="off">
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                            </div>

                            <!-- Tombol Login -->
                            <button type="submit" name="login" class="btn btn-primary w-100 py-2 mt-2">Login</button>

                            <!-- Link ke Registrasi -->
                            <div class="text-center mt-3">
                                <small>Belum punya akun admin? <a href="registrasi.php">Daftar di sini</a></small>
                            </div>
                        </form>

                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>