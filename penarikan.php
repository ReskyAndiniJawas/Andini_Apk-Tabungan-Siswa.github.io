<?php
ob_start(); // Pastikan ini di awal file

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

// Menginisialisasi variabel tanggal
$tanggal = date('Y-m-d');

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_siswa = $_POST['id_siswa'];
    $jumlah = str_replace('.', '', $_POST['jumlah']); // Hapus titik pemisah ribuan
    $saldo_awal = $_POST['saldo']; // Ambil saldo awal dari input hidden

    // Validasi jika saldo mencukupi
    if ($saldo_awal >= $jumlah) {
        // Query untuk mengambil data siswa berdasarkan id_siswa
        $query_siswa = "SELECT nama FROM siswa WHERE id_siswa = ?";
        $stmt_siswa = $conn->prepare($query_siswa);
        $stmt_siswa->bind_param("i", $id_siswa);
        $stmt_siswa->execute();
        $result_siswa = $stmt_siswa->get_result();
        $siswa = $result_siswa->fetch_assoc();

        // Membuat nomor referensi
        if ($siswa) {
            // Ambil nama siswa
            $nama_siswa = $siswa['nama'];
            // Pecah nama menjadi bagian-bagian
            $nama_parts = explode(' ', $nama_siswa);
            // Ambil inisial nama depan dan belakang
            $inisial_siswa = strtoupper(substr($nama_parts[0], 0, 1)); // Inisial nama depan
            if (count($nama_parts) > 1) {
                $inisial_siswa .= strtoupper(substr($nama_parts[1], 0, 1)); // Inisial nama belakang jika ada
            }

            // Menghasilkan urutan berdasarkan tanggal dan jenis transaksi
            $sql_max = "SELECT COUNT(*) as total FROM transaksi WHERE DATE(tanggal) = ?";
            $stmt_max = $conn->prepare($sql_max);
            $stmt_max->bind_param("s", $tanggal);
            $stmt_max->execute();
            $result_max = $stmt_max->get_result();
            $row_max = $result_max->fetch_assoc();
            $urutan = str_pad($row_max['total'] + 1, 3, '0', STR_PAD_LEFT);

            // Membuat nomor referensi
            $no_referensi = strtoupper($inisial_siswa) . "-TAR" . $urutan; // Format nomor referensi

            // Menyimpan data penarikan ke database
            $query = "INSERT INTO transaksi (id_siswa, jenis_transaksi, saldo, no_referensi) VALUES (?, 'tarik', ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ids", $id_siswa, $jumlah, $no_referensi);

            if ($stmt->execute()) {
                // Menampilkan alert dan redirect menggunakan JavaScript
                echo "<script>
                    alert('Penarikan berhasil dilakukan!');
                    window.location.href = 'admin.php?page=transaksi';
                </script>";
                exit();
            } else {
                echo "Error: " . $stmt->error; // Tampilkan error jika ada
            }
        } else {
            echo "Error: Siswa tidak ditemukan."; // Tampilkan error jika siswa tidak ditemukan
        }
    } else {
        // Jika saldo tidak mencukupi
        echo "<script>
            alert('Maaf saldo tidak mencukupi!');
            window.location.href = 'admin.php?page=transaksi';
        </script>";
        exit();
    }
}

// Query untuk mengambil data siswa
$query_siswa = "SELECT id_siswa, nama FROM siswa";
$result_siswa = $conn->query($query_siswa);
?>

<!-- Page Content -->
<div id="page-content-wrapper" style="background-color: #f9f9f9; min-height: 100vh; padding: 70px;">
    <div class="container-fluid px-4">
        <div class="card shadow-sm" style="border-radius: 10px; background-color: white; padding: 20px;">
            <h3 class="fs-4 mb-4" style="font-family: Arial, sans-serif; font-weight: bold; color: #4A4A4A;">Form Penarikan</h3>
            <form method="POST" action="">
                <div class="mb-3">
                    <label for="id_siswa" class="form-label" style="font-weight: 600;">Nama Siswa</label>
                    <select name="id_siswa" id="id_siswa" class="form-select" required onchange="updateSaldo()" style="border-radius: 5px; padding: 10px;">
                        <option value="">Pilih Siswa</option>
                        <?php
                        // Menampilkan daftar siswa
                        if ($result_siswa->num_rows > 0) {
                            while ($row = $result_siswa->fetch_assoc()) {
                                echo "<option value='{$row['id_siswa']}'>{$row['nama']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="saldo" class="form-label" style="font-weight: 600;">Saldo Tabungan</label>
                    <input type="text" name="saldo" id="saldo" class="form-control" required readonly style="border-radius: 5px; padding: 10px;">
                </div>
                
                <div class="mb-3">
                    <label for="jumlah" class="form-label" style="font-weight: 600;">Jumlah Penarikan</label>
                    <input type="text" name="jumlah" id="jumlah" class="form-control" required oninput="formatInput(this)" placeholder="0" style="border-radius: 5px; padding: 10px;">
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-danger" style="border-radius: 5px; padding: 10px 20px; font-weight: 600;">Simpan Penarikan</button>
                    <a href="admin.php?page=transaksi" class="btn btn-secondary" style="border-radius: 5px; padding: 10px 20px; font-weight: 600;">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>

<script>
function formatInput(input) {
    // Hapus semua karakter non-digit kecuali koma dan titik
    let value = input.value.replace(/[^0-9]/g, '');

    // Format angka dengan pemisah ribuan
    value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');

    // Set nilai input ke yang telah diformat
    input.value = value;
}

function updateSaldo() {
    var idSiswa = document.getElementById("id_siswa").value;

    if (idSiswa) {
        fetch("get_saldo.php?id_siswa=" + idSiswa)
            .then(response => response.json())
            .then(data => {
                document.getElementById("saldo").value = data.saldo;
            })
            .catch(error => console.error('Error:', error));
    } else {
        document.getElementById("saldo").value = '';
    }
}
</script>

<?php
$conn->close(); // Menutup koneksi di akhir
ob_end_flush(); // Mengirim output yang ditahan
?>
