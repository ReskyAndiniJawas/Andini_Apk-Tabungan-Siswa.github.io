<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="styles.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <title>Dashboard Siswa</title>
    <style>
        .sidebar-heading {
            background-color: #f8f9fa;
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
                        <a href="?page=transaksi" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
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
                <h2>Profil Siswa</h2>
                <div class="profile mb-4">
                    <p>Nama: <!-- Isi nama siswa di sini --></p>
                    <p>Kelas: <!-- Isi kelas siswa di sini --></p>
                    <p>NISN: <!-- Isi NISN siswa di sini --></p>
                    <p>Jenis Kelamin: <!-- Isi jenis kelamin siswa di sini --></p>
                </div>

                <h2>Tabungan Anda</h2>
                <p>Total Saldo: Rp <!-- Isi total saldo di sini --></p>

                <h3>Riwayat Transaksi</h3>
                <div class="transaksi">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Jenis Transaksi</th>
                                <th>Jumlah</th>
                                <th>No Referensi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan='5'>Belum ada transaksi</td>
                            </tr>
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
