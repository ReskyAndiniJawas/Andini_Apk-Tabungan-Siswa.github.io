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

    // Query untuk mengambil data siswa dan saldo total dari transaksi
    $query = "
        SELECT siswa.id_siswa, siswa.nama, siswa.kelas, 
        IFNULL(SUM(CASE WHEN transaksi.jenis_transaksi = 'setor' THEN transaksi.saldo ELSE 0 END), 0) 
        - IFNULL(SUM(CASE WHEN transaksi.jenis_transaksi = 'tarik' THEN transaksi.saldo ELSE 0 END), 0) AS total_saldo
        FROM siswa
        LEFT JOIN transaksi ON siswa.id_siswa = transaksi.id_siswa
        GROUP BY siswa.id_siswa, siswa.nama, siswa.kelas
    ";

    $result = $conn->query($query);

    // Cek apakah query berhasil
    if (!$result) {
        die("Query gagal: " . $conn->error);  // Jika query gagal, tampilkan pesan error
    }
?>

<!-- Page Content -->
<div id="page-content-wrapper">
    <nav class="navbar-light bg-transparent py-4 px-4">
        <div class="d-flex align-items-center">
            <!-- <h2 class="fs-2 m-0">Halaman Transaksi</h2> -->
        </div>
    </nav>

    <div class="container-fluid px-4">
        <!-- Tabel Transaksi -->
        <div class="row my-5">
            <div class="col d-flex justify-content-between align-items-center mb-1">
                <h3 class="fs-4 mb-1">Data Transaksi Siswa</h3>
            </div>
            <!-- Garis Horizontal -->
            <hr style="border: 3px solid black; margin: 0;"> <!-- Garis di bawah judul -->

        </div>

        <!-- Tabel untuk Data Transaksi -->
        <div class="row">
            <div class="col">
                <table class="table table-striped table-bordered bg-white rounded shadow-sm">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">Total Saldo</th>
                            <th scope="col">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Variabel untuk nomor urut
                        $nomor = 1;

                        // Menampilkan data siswa dan saldo total
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $nomor++ . "</td>
                                        <td>{$row['nama']}</td>
                                        <td>{$row['kelas']}</td>
                                        <td>Rp. " . number_format($row['total_saldo'], 2, ',', '.') . "</td>
                                        <td><a href='detail_transaksi.php?id_siswa={$row['id_siswa']}' class='btn btn-info btn-sm'>Detail</a></td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>Tidak ada data transaksi</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var el = document.getElementById("wrapper");
    var toggleButton = document.getElementById("menu-toggle");

    toggleButton.onclick = function () {
        el.classList.toggle("toggled");
    };
</script>

<?php
$conn->close();
?>
