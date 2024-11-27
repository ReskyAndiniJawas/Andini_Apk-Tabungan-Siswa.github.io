<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tabungan_siswa";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses tambah siswa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $conn->real_escape_string($_POST['nama']);
    $kelas = $conn->real_escape_string($_POST['kelas']);
    $nisn = $conn->real_escape_string($_POST['nisn']);
    $jenis_kelamin = $conn->real_escape_string($_POST['jenis_kelamin']);

    $sql = "INSERT INTO siswa (nama, kelas, nisn, jenis_kelamin) VALUES ('$nama', '$kelas', '$nisn', '$jenis_kelamin')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Siswa berhasil ditambahkan!'); window.location.href='admin.php?page=daftar_siswa';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Query data kelas dari tabel kelas
$query_kelas = "SELECT * FROM kelas";
$result_kelas = $conn->query($query_kelas);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .form-buttons a, button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            text-align: center;
            margin-right: 10px;
        }
        .submit-btn {
            background-color: #28a745; /* Warna hijau seperti di edit_siswa.php */
            color: white;
            cursor: pointer;
        }
        .submit-btn:hover {
            background-color: #218838; /* Warna hijau gelap */
        }
        .back-btn {
            background-color: #dc3545; /* Warna merah seperti di edit_siswa.php */
            color: white;
            cursor: pointer;
        }
        .back-btn:hover {
            background-color: #c82333; /* Warna merah gelap */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Siswa</h1>
        <form method="POST" action="">
            <label for="nama">Nama</label>
            <input type="text" class="form-control" name="nama" required>

            <label for="kelas">Kelas</label>
            <select class="form-select" name="kelas" required>
                <option value="">Pilih Kelas</option>
                <?php
                if ($result_kelas->num_rows > 0) {
                    // Menampilkan pilihan kelas dari database
                    while ($row_kelas = $result_kelas->fetch_assoc()) {
                        echo "<option value='" . $row_kelas['nama_kelas'] . "'>" . $row_kelas['nama_kelas'] . " - " . $row_kelas['jurusan'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Tidak ada data kelas</option>";
                }
                ?>
            </select>

            <label for="nisn">NISN</label>
            <input type="text" class="form-control" name="nisn" required>

            <label for="jenis_kelamin">Jenis Kelamin</label>
            <select class="form-select" name="jenis_kelamin" required>
                <option value="">Pilih</option>
                <option value="L">Laki-laki</option>
                <option value="P">Perempuan</option>
            </select>

            <div class="form-buttons">
                <a href="admin.php?page=daftar_siswa" class="back-btn">Batal</a>
                <button type="submit" class="submit-btn">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>

<?php
// Tutup koneksi database
$conn->close();
?>
