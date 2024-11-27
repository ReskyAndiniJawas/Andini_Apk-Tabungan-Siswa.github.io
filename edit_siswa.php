<?php
session_start();  // Pastikan session sudah dimulai

// Konfigurasi database
$host = "localhost";  // Biasanya "localhost" untuk server lokal
$user = "root";       // Username MySQL (biasanya "root" untuk XAMPP)
$pass = "";           // Password MySQL (kosong jika kamu tidak mengatur password)
$db   = "tabungan_siswa";  // Nama database yang ingin diakses

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Cek apakah parameter id disertakan
if (isset($_GET['id'])) {
    $id_siswa = $_GET['id'];

    // Ambil data siswa berdasarkan id
    $query = "SELECT * FROM siswa WHERE id_siswa = $id_siswa";
    $result = $conn->query($query);

    // Jika data ditemukan
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $nama = $row['nama'];
        $kelas = $row['kelas'];
        $nisn = $row['nisn'];
        $jenis_kelamin = $row['jenis_kelamin'];
    } else {
        echo "Data siswa tidak ditemukan!";
        exit();
    }
} else {
    echo "ID siswa tidak disertakan!";
    exit();
}

// Proses update data jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Amankan input dari form
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $kelas = mysqli_real_escape_string($conn, $_POST['kelas']);
    $nisn = mysqli_real_escape_string($conn, $_POST['nisn']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);

    // Query untuk update data siswa
    $query = "UPDATE siswa SET nama = '$nama', kelas = '$kelas', nisn = '$nisn', jenis_kelamin = '$jenis_kelamin' WHERE id_siswa = $id_siswa";

    if ($conn->query($query) === TRUE) {
        $_SESSION['message'] = "Data siswa berhasil diupdate!";
        header("Location: admin.php?page=daftar_siswa"); // Redirect ke halaman daftar siswa 
        exit();
    } else {
        $_SESSION['message'] = "Terjadi kesalahan saat mengupdate data!";
    }
}

// Query data kelas dari tabel kelas untuk dropdown
$query_kelas = "SELECT * FROM kelas";
$result_kelas = $conn->query($query_kelas);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .submit-btn,
        .back-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .submit-btn {
            background-color: #28a745; /* Warna hijau */
            color: white;
        }
        .back-btn {
            background-color: #dc3545; /* Warna merah */
            color: white;
        }
        .submit-btn:hover {
            background-color: #218838; /* Warna hijau gelap */
            transform: scale(1.05); /* Efek zoom */
        }
        .back-btn:hover {
            background-color: #c82333; /* Warna merah gelap */
            transform: scale(1.05); /* Efek zoom */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Data Siswa</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($nama); ?>" required>
            </div>
            <div class="mb-3">
                <label for="kelas" class="form-label">Kelas</label>
                <select class="form-select" id="kelas" name="kelas" required>
                    <option value="">Pilih Kelas</option>
                    <?php
                    if ($result_kelas->num_rows > 0) {
                        // Menampilkan pilihan kelas dari database
                        while ($row_kelas = $result_kelas->fetch_assoc()) {
                            $selected = ($row_kelas['nama_kelas'] == $kelas) ? 'selected' : '';
                            echo "<option value='" . $row_kelas['nama_kelas'] . "' $selected>" . $row_kelas['nama_kelas'] . " - " . $row_kelas['jurusan'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada data kelas</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nisn" class="form-label">NISN</label>
                <input type="text" class="form-control" id="nisn" name="nisn" value="<?php echo htmlspecialchars($nisn); ?>" required>
            </div>
            <div class="mb-3">
                <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                    <option value="L" <?php if ($jenis_kelamin == 'L') echo 'selected'; ?>>Laki-laki</option>
                    <option value="P" <?php if ($jenis_kelamin == 'P') echo 'selected'; ?>>Perempuan</option>
                </select>
            </div>
            <div class="form-buttons">
                <a href="admin.php?page=daftar_siswa" class="back-btn">Kembali</a>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
