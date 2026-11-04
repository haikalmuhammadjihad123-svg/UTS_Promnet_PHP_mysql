<?php
session_start();

// Cek apa admin sudah login atau belum
if (!isset($_SESSION['session_login'])) {
    header('Location: login.php');
    exit;
}

require 'function.php';

// Ambil ID dari URL
$id = $_GET["id"];

// Ambil data kamar berdasarkan ID
$kamar = query_db("SELECT * FROM kamar WHERE id = $id")[0];

// Cek apakah tombol submit ditekan
if (isset($_POST['submit'])) {
    if (edit_data($_POST) >= 0) {
        echo "<script>
            alert('Data kamar berhasil diubah!');
            document.location.href = 'index.php';
        </script>";
    } else {
        echo "<script>
            alert('Data kamar gagal diubah!');
        </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Kamar</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0 text-center">Edit Data Kamar Kos</h4>
                    </div>
                    <div class="card-body p-4">

                        <!-- Form Edit Data -->
                        <form action="" method="post" enctype="multipart/form-data">

                            <!-- Input Hidden untuk ID dan Nama Gambar Lama -->
                            <input type="hidden" name="id" value="<?= $kamar['id']; ?>">
                            <input type="hidden" name="gambarLama" value="<?= $kamar['gambar']; ?>">
                            
                            <!-- Nomor Kamar -->
                            <div class="mb-3">
                                <label for="nomor_kamar" class="form-label">Nomor Kamar</label>
                                <input type="text" name="nomor_kamar" id="nomor_kamar" class="form-control" value="<?= $kamar['nomor_kamar']; ?>" required>
                            </div>

                            <!-- Tipe Kamar -->
                            <div class="mb-3">
                                <label for="tipe" class="form-label">Tipe Kamar</label>
                                <select name="tipe" id="tipe" class="form-select" required>
                                    <option value="Standard" <?= ($kamar['tipe'] == 'Standard') ? 'selected' : ''; ?>>Standard</option>
                                    <option value="VIP" <?= ($kamar['tipe'] == 'VIP') ? 'selected' : ''; ?>>VIP</option>
                                </select>
                            </div>

                            <!-- Harga / Bulan -->
                            <div class="mb-3">
                                <label for="harga" class="form-label">Harga Sewa / Bulan (Rp)</label>
                                <input type="number" name="harga" id="harga" class="form-control" value="<?= $kamar['harga']; ?>" required>
                            </div>

                            <!-- Fasilitas -->
                            <div class="mb-3">
                                <label for="fasilitas" class="form-label">Fasilitas</label>
                                <input type="text" name="fasilitas" id="fasilitas" class="form-control" value="<?= $kamar['fasilitas']; ?>" required>
                            </div>

                            <!-- Gambar Kamar -->
                            <div class="mb-3">
                                <label class="form-label d-block">Foto Kamar Saat Ini</label>
                                <img src="img/<?= $kamar['gambar']; ?>" width="120" height="90" style="object-fit: cover; border-radius: 6px;" class="mb-2" alt="Foto Kamar">
                                
                                <label for="gambar" class="form-label d-block">Pilih Foto Baru (Jika Ingin Diganti)</label>
                                <input type="file" name="gambar" id="gambar" class="form-control">
                            </div>

                            <!-- Tombol Aksi -->
                            <div class="d-flex justify-content-between mt-4">
                                <a href="index.php" class="btn btn-secondary">Kembali</a>
                                <button type="submit" name="submit" class="btn btn-warning">Simpan Perubahan</button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>