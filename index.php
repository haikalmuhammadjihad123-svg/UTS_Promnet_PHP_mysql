<?php
session_start();

// Cek apakah admin sudah login atau belum
if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}

require 'function.php';

// =========================================
// =============== PAGINATION ==============
// =========================================

// Jumlah data yang ditampilkan per halaman
$jumlahDataPerHalaman = 3;

// Hitung jumlah keseluruhan data di tabel kamar
$jumlahData = count(query_db("SELECT * FROM kamar"));

// Hitung jumlah halaman
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);

// Menentukan halaman aktif
$halamanAktif = isset($_GET["halaman"]) ? (int) $_GET["halaman"] : 1;

// Menentukan awal data untuk LIMIT query
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;

// Ambil data kamar sesuai batasan halaman
$kamar = query_db("SELECT * FROM kamar LIMIT $awalData, $jumlahDataPerHalaman");

// Jika tombol cari ditekan
if (isset($_POST["cari"])) {
    $keyword = $_POST["keyword"];
    $kamar = cari_data($keyword);
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin Kosan</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <!-- NAVBAR ADMIN -->
    <nav class="navbar navbar-dark bg-primary px-4 py-3">
        <a class="navbar-brand fw-bold" href="index.php">🏠 ADMIN KOSAN</a>
        <div class="d-flex align-items-center gap-3">
            <span class="text-white">Halo, <b><?= $_SESSION['username']; ?></b></span>
            <a href="logout.php" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin logout?');">Logout</a>
        </div>
    </nav>

    <div class="container my-4">
        <h2 class="text-center mb-4">Daftar Data Kamar Kos</h2>

        <!-- BAR PENCARIAN & TAMBAH DATA -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <!-- Form Cari -->
            <form action="" method="post" class="d-flex gap-2">
                <input type="text" name="keyword" class="form-control" placeholder="Cari kamar..." autocomplete="off">
                <button type="submit" name="cari" class="btn btn-primary">Cari</button>
                <a href="index.php" class="btn btn-danger text-white">Reset</a>
            </form>

            <!-- Tombol Tambah Data -->
            <a href="tambah_data.php" class="btn btn-success">+ Tambah Kamar Baru</a>
        </div>

        <!-- TABEL DATA KAMAR -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th style="width: 50px;">No.</th>
                        <th>Foto Kamar</th>
                        <th>Nomor Kamar</th>
                        <th>Tipe</th>
                        <th>Harga / Bulan</th>
                        <th>Fasilitas</th>
                        <th style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kamar)) : ?>
                        <tr>
                            <td colspan="7" class="text-center py-4 text-muted">Data kamar tidak ditemukan.</td>
                        </tr>
                    <?php else : ?>
                        <?php $i = $awalData + 1; ?>
                        <?php foreach ($kamar as $row) : ?>
                            <tr>
                                <td class="text-center fw-bold"><?= $i++; ?></td>
                                <td class="text-center">
                                    <img src="img/<?= $row['gambar']; ?>" width="100" height="70" style="object-fit: cover; border-radius: 6px;" alt="Foto Kamar">
                                </td>
                                <td class="fw-bold"><?= $row['nomor_kamar']; ?></td>
                                <td><span class="badge bg-info text-dark"><?= $row['tipe']; ?></span></td>
                                <td class="fw-bold text-success">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                                <td><?= $row['fasilitas']; ?></td>
                                <td class="text-center">
                                    <a href="edit_data.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="hapus_data.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- ========================================= -->
        <!-- =============== PAGINATION ============== -->
        <!-- ========================================= -->
        <div class="d-flex justify-content-center mt-4">
            <ul class="pagination">
                <!-- Tombol Prev -->
                <?php if ($halamanAktif > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?halaman=<?= $halamanAktif - 1; ?>">&laquo; Prev</a>
                    </li>
                <?php else : ?>
                    <li class="page-item disabled">
                        <span class="page-link">&laquo; Prev</span>
                    </li>
                <?php endif; ?>

                <!-- Nomor Halaman -->
                <?php for ($i = 1; $i <= $jumlahHalaman; $i++) : ?>
                    <?php if ($i == $halamanAktif) : ?>
                        <li class="page-item active">
                            <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                    <?php else : ?>
                        <li class="page-item">
                            <a class="page-link" href="?halaman=<?= $i; ?>"><?= $i; ?></a>
                        </li>
                    <?php endif; ?>
                <?php endfor; ?>

                <!-- Tombol Next -->
                <?php if ($halamanAktif < $jumlahHalaman) : ?>
                    <li class="page-item">
                        <a class="page-link" href="?halaman=<?= $halamanAktif + 1; ?>">Next &raquo;</a>
                    </li>
                <?php else : ?>
                    <li class="page-item disabled">
                        <span class="page-link">Next &raquo;</span>
                    </li>
                <?php endif; ?>
            </ul>
        </div>

    </div>

</body>
</html>