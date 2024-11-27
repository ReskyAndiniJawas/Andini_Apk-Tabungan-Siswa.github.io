<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tabungan_siswa";

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mendapatkan ID siswa dari URL
$id_siswa = isset($_GET['id_siswa']) ? $_GET['id_siswa'] : null;

if (!$id_siswa) {
    die("ID siswa tidak ditemukan.");
}

// Query untuk mengambil informasi siswa, termasuk jenis kelamin dan NIS
$query_siswa = "SELECT nama, kelas, nisn, jenis_kelamin FROM siswa WHERE id_siswa = ?";
$stmt_siswa = $conn->prepare($query_siswa);

// Periksa apakah prepare berhasil
if (!$stmt_siswa) {
    die("Query siswa gagal dipersiapkan: " . $conn->error);
}

$stmt_siswa->bind_param("i", $id_siswa);
$stmt_siswa->execute();
$result_siswa = $stmt_siswa->get_result();
$siswa = $result_siswa->fetch_assoc();

if (!$siswa) {
    die("Siswa tidak ditemukan.");
}

// Query untuk mengambil riwayat transaksi siswa
$query_transaksi = "
    SELECT jenis_transaksi, saldo, tanggal, no_referensi
    FROM transaksi
    WHERE id_siswa = ?
    ORDER BY tanggal DESC
";
$stmt_transaksi = $conn->prepare($query_transaksi);

// Periksa apakah prepare berhasil
if (!$stmt_transaksi) {
    die("Query transaksi gagal dipersiapkan: " . $conn->error);
}

$stmt_transaksi->bind_param("i", $id_siswa);
$stmt_transaksi->execute();
$result_transaksi = $stmt_transaksi->get_result();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 85%; /* Lebar container lebih kecil agar tampilan lebih kompak */
            max-width: 900px; /* Batasi ukuran maksimal container */
            margin: 20px auto; /* Center-kan container di layar */
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2, h4 {
            color: #333;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px; /* Ukuran padding lebih kecil */
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            font-size: 14px; /* Ukuran tombol lebih kecil */
            padding: 8px 15px; /* Padding tombol lebih kecil */
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2>Detail Transaksi Siswa</h2>
    <div class="row">
        <div class="col-md-6">
            <h4>Nama: <?php echo $siswa['nama']; ?></h4>
            <h4>Kelas: <?php echo $siswa['kelas']; ?></h4>
            <h4>NIS: <?php echo $siswa['nisn']; ?></h4> <!-- Menampilkan NIS -->
            <h4>Jenis Kelamin: <?php echo ($siswa['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></h4> <!-- Menampilkan Jenis Kelamin -->
        </div>
    </div>

    <hr>

    <h4>Riwayat Transaksi</h4>
    <table class="table table-striped table-bordered bg-white rounded shadow-sm">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Jenis Transaksi</th>
                <th scope="col">Jumlah</th>
                <th scope="col">Tanggal</th>
                <th scope="col">No. Referensi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_transaksi->num_rows > 0) {
                $nomor = 1;
                while ($row = $result_transaksi->fetch_assoc()) {
                    echo "<tr>
                            <td>" . $nomor++ . "</td>
                            <td>" . ucfirst($row['jenis_transaksi']) . "</td>
                            <td>Rp. " . number_format($row['saldo'], 2, ',', '.') . "</td>
                            <td>{$row['tanggal']}</td>
                            <td>{$row['no_referensi']}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='5'>Tidak ada riwayat transaksi.</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Tombol Cetak -->
    <button class="btn btn-primary" onclick="window.print();">Cetak</button>
    <a href="#" class="btn btn-secondary" onclick="window.history.back();">Kembali</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

<?php
$conn->close();
?>
