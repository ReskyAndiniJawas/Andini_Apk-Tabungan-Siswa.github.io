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
$id_siswa = isset($_GET['id_siswa']) ? $_GET['id_siswa'] : null; // Ganti 'id_user' dengan 'id_siswa'

if ($id_siswa) {
    // Query untuk menghitung saldo total
    $query = "
        SELECT 
            IFNULL(SUM(CASE WHEN jenis_transaksi = 'setor' THEN saldo ELSE 0 END), 0) 
            - IFNULL(SUM(CASE WHEN jenis_transaksi = 'tarik' THEN saldo ELSE 0 END), 0) AS total_saldo
        FROM transaksi
        WHERE id_siswa = ?  -- Perbaikan di sini
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_siswa);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    // Mengembalikan saldo dalam format JSON
    echo json_encode(['saldo' => $data['total_saldo'] ? $data['total_saldo'] : 0]);
} else {
    echo json_encode(['saldo' => 0]);
}

$conn->close();
?>
