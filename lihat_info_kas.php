<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Info Kas Siswa</title>
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 20px;
            border-radius: 8px;
            padding: 15px; /* Perkecil padding */
            background-color: #ffffff;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            max-width: 800px; /* Batasi lebar kontainer */
        }
        h2 {
            color: #343a40;
            text-align: center;
            margin-bottom: 15px; /* Perkecil margin bawah */
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
        .btn-print {
            background-color: #28a745; /* Warna hijau */
            color: white;
        }
        .btn-print:hover {
            background-color: #218838;
        }
        .alert {
            margin-top: 20px;
        }
        table {
            margin-top: 20px;
        }
        .total-saldo {
            font-weight: bold;
            margin-top: 15px;
        }
    </style>
    <script>
        function printPage() {
            window.print(); // Fungsi untuk mencetak halaman
        }
    </script>
</head>
<body>

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

$start_date = '';
$end_date = '';
$id_siswa = '';
$transactions = [];
$total_saldo = 0; // Variabel untuk menyimpan total saldo

// Mengambil data dari URL
if (isset($_GET['start_date'], $_GET['end_date'], $_GET['id_siswa'])) {
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
    $id_siswa = $_GET['id_siswa'];

    // Query untuk mendapatkan data transaksi dalam rentang waktu yang dipilih untuk siswa tertentu
    $stmt = $conn->prepare("
        SELECT siswa.nama, siswa.kelas, transaksi.jenis_transaksi, transaksi.saldo, transaksi.tanggal
        FROM transaksi
        JOIN siswa ON transaksi.id_siswa = siswa.id_siswa
        WHERE transaksi.id_siswa = ? AND transaksi.tanggal BETWEEN ? AND ?
        ORDER BY transaksi.tanggal ASC
    ");
    
    $stmt->bind_param("iss", $id_siswa, $start_date, $end_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $transactions[] = $row;
            // Tambahkan saldo untuk total saldo
            $total_saldo += $row['saldo'];
        }
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<div class="container">
    <h2>Info Kas Siswa</h2>

    <!-- Menampilkan data transaksi -->
    <?php if (!empty($transactions)): ?>
        <table class="table table-striped table-bordered">
            <thead class="dark">
                <tr>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>Jenis Transaksi</th>
                    <th>Saldo</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($transactions as $transaction): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($transaction['nama']); ?></td>
                        <td><?php echo htmlspecialchars($transaction['kelas']); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($transaction['jenis_transaksi'])); ?></td>
                        <td>Rp. <?php echo number_format($transaction['saldo'], 2, ',', '.'); ?></td>
                        <td><?php echo htmlspecialchars($transaction['tanggal']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Menampilkan total saldo -->
        <div class="total-saldo">Total Saldo Akhir: Rp. <?php echo number_format($total_saldo, 2, ',', '.'); ?></div>
    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($id_siswa)): ?>
        <div class="alert alert-warning" role="alert">
            Tidak ada transaksi ditemukan untuk siswa ini pada rentang tanggal yang dipilih.
        </div>
    <?php endif; ?>

    <a href="admin.php?page=info_transaksi" class="btn btn-secondary mt-3">Kembali</a>
    <button onclick="printPage()" class="btn btn-print mt-3 float-right">Cetak</button> <!-- Tombol Cetak -->
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
