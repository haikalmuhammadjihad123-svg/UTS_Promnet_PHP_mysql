<?php
session_start();

// Cek apakah admin sudah login atau belum
if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}

require 'function.php';

// Cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    if (tambah_data($_POST) > 0) {
        echo "<script>
            alert('Data kamar berhasil ditambahkan!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data kamar gagal ditambahkan!');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Kamar</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0 text-center">Tambah Data Kamar Kos</h4>
                    </div>
                    <div class="card-body p-4">

                        <!-- Form Tambah Data -->
                        <form action="" method="post" enctype="multipart/form-data">
                            
                            <!-- Nomor Kamar -->
                            <div class="mb-3">
                                <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
                                <input type="text" name="nomor_kamar" id="nomor_kamar" class="form-control" placeholder="Contoh: Kamar 104" required>
                            </div>

                            <!-- Tipe Kamar -->
                            <div class="mb-3">
                                <label for="tipe" class="form-label">Tipe Kamar</label>
                                <select name="tipe" id="tipe" class="form-select" required>
                                    <option value="" disabled selected>-- Pilih Tipe Kamar --</option>
                                    <option value="Standard">Standard</option>
                                    <option value="VIP">VIP</option>
                                </select>
                            </div>

                            <!-- Harga / Bulan -->
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga Sewa / Bulan (Rp)</label>
                                <input type="number" name="harga" id="harga" class="form-control" placeholder="Contoh: 850000" required>
                            </div>

                            <!-- Fasilitas -->
                            <div class="mb-3">
                                <label for="fasilitas" class="form-label">Fasilitas</label>
                                <input type="text" name="fasilitas" id="fasilitas" class="form-control" placeholder="Contoh: AC, WiFi, Kasur, KM Dalam" required>
                            </div>

                            <!-- Upload Gambar -->
                            <div class="mb-3">
                                <label for="gambar" class="form-label">Foto Kamar (jpg, jpeg, png)</label>
                                <input type="file" name="gambar" id="gambar" class="form-control" required>
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
                                <button type="submit" name="submit" class="btn btn-primary">Simpan Data</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>