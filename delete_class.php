<?php
// koneksi.php - Ganti dengan informasi koneksi yang sesuai
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "tabungan_siswa"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Menghapus kelas berdasarkan id
if (isset($_GET['id'])) {
    $id_kelas = $_GET['id'];
    $query = "DELETE FROM kelas WHERE id_kelas='$id_kelas'";

    if ($conn->query($query) === TRUE) {
        // Redirect ke halaman class dengan pesan sukses
        header("Location: admin.php?page=class&message=Kelas berhasil dihapus");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Menutup koneksi
$conn->close();
?>
