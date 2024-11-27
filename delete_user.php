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

// Menghapus user berdasarkan id
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];
    $query = "DELETE FROM user WHERE id_user='$id_user'";

    if ($conn->query($query) === TRUE) {
        // Redirect ke halaman user dengan pesan sukses
        header("Location: admin.php?page=user&message=User berhasil dihapus");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

$conn->close();
?>
