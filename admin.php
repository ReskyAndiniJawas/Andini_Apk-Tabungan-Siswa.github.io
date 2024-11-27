<?php
session_start(); // Mulai session

// Cek apakah user sudah login dan apakah user adalah admin
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

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

// Query untuk mengambil data siswa dari database
$query = "SELECT * FROM siswa";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
    <link rel="stylesheet" href="styles.css" />
    <style>
    /* Menghilangkan bullet points pada list */
    .list-group, .list-group ul {
        list-style-type: none; /* Menghilangkan bullet points */
        padding: 0; /* Menghilangkan padding default */
        margin: 0; /* Menghilangkan margin default */
    }

    .list-group-item {
        border: none; /* Menghilangkan border item list */
    }
    </style>

    <title>Tabungan Siswa</title>
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
                    <li class="<?php echo (!isset($_GET['page']) || $_GET['page'] == 'home') ? 'active' : ''; ?>">
                        <a href="?page=home" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </li>
                    <li class="<?php echo ($_GET['page'] == 'daftar_siswa') ? 'active' : ''; ?>">
                        <a href="?page=daftar_siswa" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                            <i class="fas fa-user-graduate me-2"></i>Daftar Siswa
                        </a>
                    </li>
                    <li class="<?php echo ($_GET['page'] == 'class') ? 'active' : ''; ?>">
                        <a href="?page=class" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                            <i class="fas fa-chalkboard-teacher me-2"></i>Kelas
                        </a>
                    </li>
                    <li class="<?php echo ($_GET['page'] == 'transaksi') ? 'active' : ''; ?>">
                        <a href="?page=transaksi" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                            <i class="fas fa-exchange-alt me-2"></i>Transaksi
                        </a>

                        <!-- Sub-menu untuk Setoran dan Penarikan -->
                        <?php if (isset($_GET['page']) && $_GET['page'] == 'transaksi'): ?>
                        <ul class="treeview-menu">
                            <li>
                                <a href="?page=setoran" class="list-group-item list-group-item-action bg-transparent second-text">Setoran</a>
                            </li>
                            <li>
                                <a href="?page=penarikan" class="list-group-item list-group-item-action bg-transparent second-text">Penarikan</a>
                            </li>
                            <li>
                                <a href="?page=info_transaksi" class="list-group-item list-group-item-action bg-transparent second-text">Info Transaksi</a>
                            </li>
                        </ul>
                        <?php endif; ?>
                    </li>
                    <li class="<?php echo ($_GET['page'] == 'user') ? 'active' : ''; ?>">
                        <a href="?page=user" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                            <i class="fas fa-users-cog me-2"></i>User
                        </a>
                    </li>
                    <li class="<?php echo ($_GET['page'] == 'laporan') ? 'active' : ''; ?>">
                        <a href="?page=laporan" class="list-group-item list-group-item-action bg-transparent second-text fw-bold">
                            <i class="fas fa-file-alt me-2"></i>Laporan
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
                    <h2 class="fs-2 m-0">
                        <?php
                        // Menentukan judul halaman berdasarkan page yang diakses
                        if (!isset($_GET['page']) || $_GET['page'] == 'home') {
                            echo 'Dashboard';
                        } elseif ($_GET['page'] == 'daftar_siswa') {
                            echo 'Daftar Siswa';
                        } elseif ($_GET['page'] == 'class') {
                            echo 'Kelas';
                        } elseif ($_GET['page'] == 'transaksi') {
                            echo 'Transaksi';
                        } elseif ($_GET['page'] == 'setoran') {
                            echo 'Halaman Setoran';
                        } elseif ($_GET['page'] == 'info_transaksi') {
                            echo 'Info Transaksi';
                        } elseif ($_GET['page'] == 'penarikan') {
                            echo 'Halaman Penarikan';
                        } elseif ($_GET['page'] == 'user') {
                            echo 'User';
                        } elseif ($_GET['page'] == 'laporan') {
                            echo 'Laporan';
                        } else {
                            echo 'Halaman Tidak Ditemukan';
                        }
                        ?>
                    </h2>
                </div>

                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle second-text fw-bold" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user me-2"></i>Admin
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="#">Profile</a></li>
                                <li><a class="dropdown-item" href="#">Settings</a></li>
                                <li><a class="dropdown-item" href="#">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

            <?php 
                // Menampilkan konten halaman berdasarkan parameter page
                $page = isset($_GET['page']) ? $_GET['page'] : '';
                if ($page !== '' && file_exists($page . '.php')) {
                    include $page . '.php';
                } else {
                    include '404.php'; // Ganti dengan halaman 404 jika file tidak ditemukan
                }
            ?>
        </div>
        <!-- /#page-content-wrapper -->
    </div>
    <!-- /#wrapper -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"></script>
    <script src="script.js"></script>
</body>

</html>
