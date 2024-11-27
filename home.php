<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tabungan_siswa";

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Query untuk mengambil data siswa terdaftar
$querySiswa = "SELECT COUNT(*) AS total_siswa FROM siswa";
$resultSiswa = $conn->query($querySiswa);
$rowSiswa = $resultSiswa->fetch_assoc(); // Ambil jumlah siswa

// Query untuk total setoran
$querySetoran = "SELECT SUM(saldo) AS total_setoran FROM transaksi WHERE jenis_transaksi = 'setor'";
$resultSetoran = $conn->query($querySetoran);
$rowSetoran = $resultSetoran->fetch_assoc(); // Ambil total setoran

// Query untuk total penarikan
$queryPenarikan = "SELECT SUM(saldo) AS total_penarikan FROM transaksi WHERE jenis_transaksi = 'tarik'";
$resultPenarikan = $conn->query($queryPenarikan);
$rowPenarikan = $resultPenarikan->fetch_assoc(); // Ambil total penarikan

// Query untuk setoran per bulan
$querySetoranBulan = "SELECT MONTH(tanggal) AS bulan, SUM(saldo) AS total_setoran_bulan 
                      FROM transaksi 
                      WHERE jenis_transaksi = 'setor' 
                      GROUP BY MONTH(tanggal)";
$resultSetoranBulan = $conn->query($querySetoranBulan);
$setoranData = array_fill(0, 12, 0); // Inisialisasi array untuk 12 bulan

// Menyimpan data setoran per bulan
while ($row = $resultSetoranBulan->fetch_assoc()) {
    $setoranData[$row['bulan'] - 1] = (float)$row['total_setoran_bulan'];
}

// Query untuk penarikan per bulan
$queryPenarikanBulan = "SELECT MONTH(tanggal) AS bulan, SUM(saldo) AS total_penarikan_bulan 
                        FROM transaksi 
                        WHERE jenis_transaksi = 'tarik' 
                        GROUP BY MONTH(tanggal)";
$resultPenarikanBulan = $conn->query($queryPenarikanBulan);
$penarikanData = array_fill(0, 12, 0); // Inisialisasi array untuk 12 bulan

// Menyimpan data penarikan per bulan
while ($row = $resultPenarikanBulan->fetch_assoc()) {
    $penarikanData[$row['bulan'] - 1] = (float)$row['total_penarikan_bulan'];
}

// Menutup koneksi setelah selesai mengambil data
$conn->close();
?>

<!-- Memasukkan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container-fluid px-4">
    <!-- Ringkasan -->
    <div class="row g-3 my-2">
        <!-- Card Siswa Terdaftar -->
        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded h-100">
                <div>
                    <h3 class="fs-4"><?php echo $rowSiswa['total_siswa']; ?></h3>
                    <p class="fs-5">Siswa Terdaftar</p>
                </div>
                <button class="btn btn-success btn-sm rounded-circle p-3"> <!-- Ubah ke warna hijau -->
                    <i class="fas fa-user-graduate fs-2"></i>
                </button>
            </div>
        </div>

        <!-- Card Total Setoran -->
        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded h-100">
                <div>
                    <h3 class="fs-4">Rp. <?php echo number_format($rowSetoran['total_setoran'], 2, ',', '.'); ?></h3>
                    <p class="fs-5">Total Setoran</p>
                </div>
                <button class="btn btn-success btn-sm rounded-circle p-3"> <!-- Ubah ke warna hijau -->
                    <i class="fas fa-hand-holding-usd fs-2"></i>
                </button>
            </div>
        </div>

        <!-- Card Total Penarikan -->
        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded h-100">
                <div>
                    <h3 class="fs-4">Rp. <?php echo number_format($rowPenarikan['total_penarikan'], 2, ',', '.'); ?></h3>
                    <p class="fs-5">Total Penarikan</p>
                </div>
                <button class="btn btn-success btn-sm rounded-circle p-3"> <!-- Ubah ke warna hijau -->
                    <i class="fas fa-truck fs-2"></i>
                </button>
            </div>
        </div>

        <!-- Card Total Saldo -->
        <div class="col-md-3">
            <div class="p-3 bg-white shadow-sm d-flex justify-content-around align-items-center rounded h-100">
                <div>
                    <h3 class="fs-4">Rp. <?php
                    // Menghitung total saldo
                    $totalSaldo = $rowSetoran['total_setoran'] - $rowPenarikan['total_penarikan'];
                    echo number_format($totalSaldo, 2, ',', '.'); ?></h3>
                    <p class="fs-5">Total Saldo</p>
                </div>
                <button class="btn btn-success btn-sm rounded-circle p-3"> <!-- Ubah ke warna hijau -->
                    <i class="fas fa-chart-line fs-2"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Grafik Bar untuk Setoran dan Penarikan Bulanan -->
    <div class="row my-3">
        <h3 class="fs-4 mb-3">Grafik Setoran dan Penarikan Bulanan</h3>
        <div class="col" style="max-width: 775px;">
            <canvas id="barChart" width="600" height="350"></canvas>
        </div>
    </div>

    <!-- Grafik Line untuk Total Saldo Bulanan -->
    <div class="row my-3">
        <h3 class="fs-4 mb-3">Grafik Total Saldo Bulanan</h3>
        <div class="col" style="max-width: 775px;">
            <canvas id="lineChart" width="600" height="350"></canvas>
        </div>
    </div>

    <!-- Grafik Pie untuk Distribusi Jenis Transaksi -->
    <div class="row my-3">
        <h3 class="fs-4 mb-3">Distribusi Jenis Transaksi</h3>
        <div class="col" style="max-width: 550px;">
            <canvas id="pieChart" width="500" height="250"></canvas>
        </div>
    </div>
</div>

<script>
    // Grafik Bar untuk Setoran dan Penarikan Bulanan
    var barCtx = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Setoran',
                data: <?php echo json_encode($setoranData); ?>,
                backgroundColor: 'rgba(75, 192, 192, 0.6)'
            },
            {
                label: 'Penarikan',
                data: <?php echo json_encode($penarikanData); ?>,
                backgroundColor: 'rgba(255, 99, 132, 0.6)'
            }]
        },
        options: { responsive: true }
    });

    // Grafik Line untuk Total Saldo Setiap Bulan
    var lineCtx = document.getElementById('lineChart').getContext('2d');
    var lineChart = new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Total Saldo',
                data: <?php echo json_encode(array_map(function($setoran, $penarikan) { return $setoran - $penarikan; }, $setoranData, $penarikanData)); ?>,
                borderColor: 'rgba(54, 162, 235, 0.6)',
                fill: false
            }]
        },
        options: { responsive: true }
    });

    // Grafik Pie untuk Distribusi Jenis Transaksi
    var pieCtx = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(pieCtx, {
        type: 'pie',
        data: {
            labels: ['Setoran', 'Penarikan'],
            datasets: [{
                data: [<?php echo $rowSetoran['total_setoran']; ?>, <?php echo $rowPenarikan['total_penarikan']; ?>],
                backgroundColor: ['rgba(75, 192, 192, 0.6)', 'rgba(255, 99, 132, 0.6)']
            }]
        },
        options: { responsive: true }
    });
</script>

<style>
    .fs-4 {
        font-size: 1.25rem;
    }

    .fs-5 {
        font-size: 1rem;
    }

    .icon-container i {
        font-size: 3rem; /* Menyesuaikan ukuran ikon */
    }
    
    /* Responsif untuk tampilan kecil */
    @media (max-width: 768px) {
        .fs-4 {
            font-size: 1rem; /* Menyesuaikan ukuran font */
        }

        .fs-5 {
            font-size: 0.875rem; /* Menyesuaikan ukuran font */
        }

        .icon-container i {
            font-size: 2.5rem; /* Menyesuaikan ukuran ikon */
        }
    }
</style>
