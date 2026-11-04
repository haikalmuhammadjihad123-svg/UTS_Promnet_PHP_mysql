<?php
session_start();

// Cek apakah admin sudah login atau belum
if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}

require 'function.php';

// Ambil ID dari URL
$id = $_GET["id"];

// Jalankan fungsi hapus data
if (hapus_data($id) > 0) {
    echo "<script>
        alert('Data berhasil dihapus!');
        document.location.href = 'index.php';
    </script>";
} else {
    echo "<script>
        alert('Data gagal dihapus!');
        document.location.href = 'index.php';
    </script>";
}
?>