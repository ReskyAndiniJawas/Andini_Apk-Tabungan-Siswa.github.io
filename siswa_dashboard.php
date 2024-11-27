<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit();
}

$id_siswa = $_SESSION['id_siswa'];

// Query untuk mengambil data siswa
$query_siswa = "SELECT * FROM siswa WHERE id_siswa = ?";
$stmt_siswa = $conn->prepare($query_siswa);
$stmt_siswa->bind_param("i", $id_siswa);
$stmt_siswa->execute();
$result_siswa = $stmt_siswa->get_result();
$data_siswa = $result_siswa->fetch_assoc();

// Query untuk mengambil riwayat transaksi siswa
$query_transaksi = "SELECT * FROM transaksi WHERE id_siswa = ? ORDER BY tanggal DESC";
$stmt_transaksi = $conn->prepare($query_transaksi);
$stmt_transaksi->bind_param("i", $id_siswa);
$stmt_transaksi->execute();
$result_transaksi = $stmt_transaksi->get_result();

// Query untuk menghitung saldo total
$query_saldo = "SELECT 
    SUM(CASE WHEN jenis_transaksi = 'setor' THEN saldo ELSE 0 END) - 
    SUM(CASE WHEN jenis_transaksi = 'tarik' THEN saldo ELSE 0 END) AS saldo_total 
    FROM transaksi 
    WHERE id_siswa = ?";
$stmt_saldo = $conn->prepare($query_saldo);
$stmt_saldo->bind_param("i", $id_siswa);
$stmt_saldo->execute();
$result_saldo = $stmt_saldo->get_result();
$saldo_total = $result_saldo->fetch_assoc()['saldo_total'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Dashboard Siswa</title>
    <style>
    body {
        background-color: #f4f7fa;
        font-family: 'Arial', sans-serif;
    }
    .sidebar-heading {
        background-color: #6c757d;
        color: #fff;
    }

    .container {
        padding: 10px;
        border-radius: 10px;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        background-color: #fff;
        max-width: 900px;
        margin: auto;
    }

    h2 {
        font-size: 2.1rem;
        margin-bottom: 10px;
    }

    .table {
        font-size: 0.9rem;
        width: 100%;
        max-width: 100%;
    }

    .table th {
        background-color: #6c757d;
        color: white;
    }

    .table-hover tbody tr:hover {
        background-color: #e9ecef;
    }

    /* Styling untuk biodata siswa */
    .biodata-item {
        font-size: 1.1rem;
        font-family: 'Verdana', sans-serif;
        color: #333;
        margin-bottom: 5px;
        position: relative;
        padding-left: 15px;
    }

    .biodata-item::before {
        content: "•";
        position: absolute;
        left: 0;
        color: #6c757d;
        font-size: 1rem;
    }

    /* Styling untuk saldo total */
    .saldo-total-section {
        margin-top: 30px; /* Tambahkan jarak antara biodata dan saldo total */
    }
    .saldo-total {
        font-size: 1.5rem;
        color: #333;
    }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4 primary-text fs-4 fw-bold text-uppercase border-bottom">
                <i class="fas fa-piggy-bank me-2"></i>TabungGo
            </div>
            <div class="list-group list-group-flush my-3">
                <ul class='list-unstyled'>
                    <li>
                        <a href="siswa_dashboard.php" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                            <i class="fas fa-exchange-alt me-2"></i>Tabungan
                        </a>
                    </li>
                </ul>
                <a href="logout.php" class="list-group-item list-group-item-action bg-transparent text-danger fw-bold">
                    <i class="fas fa-power-off me-2"></i>Logout
                </a>
            </div>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4 px-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-align-left primary-text fs-4 me-3" id="menu-toggle"></i>
                    <h2 class="fs-2 m-0">Dashboard Siswa</h2>
                </div>
            </nav>

            <div class="container">
                <h2>Biodata Siswa</h2>
                <p class="biodata-item">Nama: <?php echo htmlspecialchars($data_siswa['nama']); ?></p>
                <p class="biodata-item">Kelas: <?php echo htmlspecialchars($data_siswa['kelas']); ?></p>
                <p class="biodata-item">NISN: <?php echo htmlspecialchars($data_siswa['nisn']); ?></p>
                <p class="biodata-item">Jenis Kelamin: <?php echo ($data_siswa['jenis_kelamin'] == 'L') ? 'Laki-laki' : 'Perempuan'; ?></p>
            
                <div class="saldo saldo-total-section">
                    <h2>Saldo Total</h2>
                    <p class="saldo-total">Saldo: Rp <?php echo number_format($saldo_total, 2, ',', '.'); ?></p>

                    <h2>Riwayat Transaksi</h2>
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Jenis Transaksi</th>
                                <th>Jumlah</th>
                                <th>Tanggal</th>
                                <th>No Referensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_transaksi->num_rows > 0) {
                                $no = 1;
                                while ($data_transaksi = $result_transaksi->fetch_assoc()) {
                                    $tanggal = date("d-m-Y H:i", strtotime($data_transaksi['tanggal']));
                                    $jumlah = isset($data_transaksi['saldo']) ? $data_transaksi['saldo'] : 0;
                                    echo "<tr>
                                            <td>{$no}</td>
                                            <td>" . strtoupper(htmlspecialchars($data_transaksi['jenis_transaksi'])) . "</td>
                                            <td>Rp " . number_format($jumlah, 2, ',', '.') . "</td>
                                            <td>" . htmlspecialchars($tanggal) . "</td>
                                            <td>" . htmlspecialchars($data_transaksi['no_referensi']) . "</td>
                                        </tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='5' class='text-center'>Tidak ada riwayat transaksi.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
// Menutup koneksi database
$conn->close();
?>
