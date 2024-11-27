<?php
// session_start(); // Pastikan session sudah dimulai

// Tampilkan alert jika ada pesan di session
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Hapus pesan setelah ditampilkan
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

// Mengambil nilai pencarian dari form
$search = isset($_POST['search']) ? $_POST['search'] : '';

// Query untuk mengambil data siswa dari database berdasarkan pencarian
$query = "SELECT * FROM siswa WHERE nama LIKE '%$search%' OR kelas LIKE '%$search%' OR nisn LIKE '%$search%'";
$result = $conn->query($query);
?>

<!-- Page Content -->
<div id="page-content-wrapper">
    <nav class="navbar-light bg-transparent py-4 px-4">
        <div class="d-flex align-items-center">
            <!-- <h2 class="fs-2 m-0">Daftar Siswa</h2> -->
        </div>
    </nav>

    <div class="container-fluid px-4">
        <!-- Tabel Data Siswa -->
        <div class="row my-2">
            <div class="col d-flex justify-content-between align-items-center mb-2">
            <h3 class="fs-4 mb-1" style="font-size: 40px !important; font-weight: bold; font-family: 'Arial', sans-serif;">Data Siswa</h3>
                </div>
        </div>

        <!-- Garis horizontal setelah judul "Datr Siswa" -->
        <hr>

        <!-- Form Pencarian di atas tabel -->
        <form method="POST" class="mb-3">
            <div class="input-group" style="width: 300px;"> <!-- Mengatur lebar form pencarian -->
                <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari Siswa..." value="<?php echo htmlspecialchars($search); ?>">
                <button class="btn btn-success btn-sm" type="submit">Cari</button> <!-- Mengubah warna tombol menjadi hijau -->
            </div>
        </form>

        <!-- Tombol Tambah Siswa di bawah judul -->
        <div class="row my-3"> <!-- Menambahkan row baru untuk tombol -->
            <div class="col text-end"> <!-- Posisi tombol di sebelah kanan -->
                <a href="add_siswa.php" class="btn btn-success">Tambah Siswa</a>
            </div>
        </div>

        <!-- Tabel untuk Data Siswa -->
        <div class="row">
            <div class="col">
                <table class="table bg-white rounded shadow-sm table-hover">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Kelas</th>
                            <th scope="col">NISN</th>
                            <th scope="col">Jenis Kelamin</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Variabel untuk nomor urut
                        $nomor = 1;

                        // Menampilkan data siswa dari database
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>" . $nomor++ . "</td>
                                        <td>{$row['nama']}</td>
                                        <td>{$row['kelas']}</td>
                                        <td>{$row['nisn']}</td>";

                                // Menampilkan jenis kelamin berdasarkan data
                                if ($row['jenis_kelamin'] == 'L') {
                                    echo "<td>Laki-laki</td>";
                                } else if ($row['jenis_kelamin'] == 'P') {
                                    echo "<td>Perempuan</td>";
                                } else {
                                    echo "<td> - </td>";
                                }

                                echo "<td>
                                        <a href='edit_siswa.php?id={$row['id_siswa']}' class='btn btn-warning btn-sm'>Update</a>
                                        <a href='delete.php?id={$row['id_siswa']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus siswa ini?\");'>Delete</a>
                                      </td>
                                      </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6'>Tidak ada data siswa</td></tr>";
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
