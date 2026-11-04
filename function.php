<?php 
// 1. KONEKSI KE DATABASE
$conn = mysqli_connect("localhost", "root", "", "db_kost");

// 2. FUNGSI UNTUK MENJALANKAN QUERY DAN MENGAMBIL DATA
function query_db($query) {
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// 3. FUNGSI TAMBAH DATA KAMAR
function tambah_data($data) {
    global $conn;

    // Ambil data dari tiap input form
    $nomor_kamar = htmlspecialchars($data["nomor_kamar"]);
    $tipe        = htmlspecialchars($data["tipe"]);
    $harga       = htmlspecialchars($data["harga"]);
    $fasilitas   = htmlspecialchars($data["fasilitas"]);

    // Jalankan fungsi upload gambar
    $gambar = upload_gambar();
    if (!$gambar) {
        return false;
    }

    // Query insert data
    $query = "INSERT INTO kamar VALUES ('', '$nomor_kamar', '$tipe', '$harga', '$fasilitas', '$gambar')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// 4. FUNGSI HAPUS DATA KAMAR
function hapus_data($id) {
    global $conn;

    $query = "DELETE FROM kamar WHERE id = $id";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

// 5. FUNGSI EDIT / UBAH DATA KAMAR
function edit_data($data) {
    global $conn;

    $id          = $data["id"];
    $nomor_kamar = htmlspecialchars($data["nomor_kamar"]);
    $tipe        = htmlspecialchars($data["tipe"]);
    $harga       = htmlspecialchars($data["harga"]);
    $fasilitas   = htmlspecialchars($data["fasilitas"]);
    $gambarLama  = htmlspecialchars($data["gambarLama"]);

    // Cek apakah admin pilih gambar baru atau tidak
    if ($_FILES['gambar']['error'] === 4) {
        $gambar = $gambarLama; // Pakai gambar yang lama
    } else {
        $gambar = upload_gambar(); // Upload gambar yang baru
        if (!$gambar) {
            return false;
        }
    }

    // Query update data
    $query = "UPDATE kamar SET
                nomor_kamar = '$nomor_kamar',
                tipe        = '$tipe',
                harga       = '$harga',
                fasilitas   = '$fasilitas',
                gambar      = '$gambar'
              WHERE id = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}

// 6. FUNGSI CARI DATA KAMAR (SEARCH)
function cari_data($keyword) {
    global $conn;

    $keyword = mysqli_real_escape_string($conn, $keyword);
    $query = "SELECT * FROM kamar WHERE
                nomor_kamar LIKE '%$keyword%' OR
                tipe LIKE '%$keyword%' OR
                harga LIKE '%$keyword%' OR
                fasilitas LIKE '%$keyword%'";

    return query_db($query);
}

// 7. FUNGSI UPLOAD GAMBAR
function upload_gambar() {
    $namaFile   = $_FILES['gambar']['name'];
    $ukuranFile = $_FILES['gambar']['size'];
    $error      = $_FILES['gambar']['error'];
    $tmpName    = $_FILES['gambar']['tmp_name'];

    // Cek apakah ada file yang diupload
    if ($error === 4) {
        echo "<script>
            alert('Silakan pilih file gambar terlebih dahulu!');
        </script>";
        return false;
    }

    // Cek apakah file yang diupload adalah gambar
    $ekstensiValid = ['jpg', 'jpeg', 'png'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiValid)) {
        echo "<script>
            alert('File yang kamu upload bukan gambar (harus jpg, jpeg, atau png)!');
        </script>";
        return false;
    }

    // Cek ukuran file
    if ($ukuranFile > 2000000) {
        echo "<script>
            alert('Ukuran gambar terlalu besar! Maksimal 2MB');
        </script>";
        return false;
    }

    // Generate nama gambar baru dengan uniqid
    $namaFileBaru = uniqid() . '.' . $ekstensiGambar;

    // Pindahkan file ke folder img/
    move_uploaded_file($tmpName, 'img/' . $namaFileBaru);

    return $namaFileBaru;
}

// 8. FUNGSI REGISTRASI ADMIN BARU
function registrasi($data) {
    global $conn;

    $username            = strtolower(stripslashes($data["username"]));
    $password            = mysqli_real_escape_string($conn, $data["password"]);
    $konfirmasi_password = mysqli_real_escape_string($conn, $data["konfirmasi_password"]);

    // Cek apakah username sudah ada di database
    $cek = mysqli_query($conn, "SELECT username FROM user WHERE username = '$username'");
    if (mysqli_fetch_assoc($cek)) {
        echo "<script>
            alert('Username sudah terdaftar! Gunakan username lain.');
        </script>";
        return false;
    }

    // Cek konfirmasi password
    if ($password !== $konfirmasi_password) {
        echo "<script>
            alert('Konfirmasi password tidak sesuai!');
        </script>";
        return false;
    }

    // Enkripsi password menggunakan password_hash bawaan PHP
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    // Simpan data user ke database
    mysqli_query($conn, "INSERT INTO user VALUES ('', '$username', '$passwordHash')");

    return mysqli_affected_rows($conn);
}
?>