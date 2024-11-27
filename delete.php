<?php
session_start(); // Mulai session

// Mengimpor file koneksi
require 'koneksi.php'; // Pastikan jalur ke koneksi.php benar

if (isset($_GET['id'])) {
    $id_siswa = $_GET['id'];

    // Query untuk menghapus data siswa
    $query = "DELETE FROM siswa WHERE id_siswa = '$id_siswa'";
    if ($conn->query($query) === TRUE) {
        // Simpan pesan sukses ke dalam session
        $_SESSION['message'] = "Data siswa berhasil dihapus!";
        $_SESSION['message_type'] = "success"; // Jenis pesan (untuk alert warna hijau)
    } else {
        // Simpan pesan error ke dalam session
        $_SESSION['message'] = "Gagal menghapus data siswa: " . $conn->error;
        $_SESSION['message_type'] = "danger"; // Jenis pesan (untuk alert warna merah)
    }

    // Redirect ke halaman daftar siswa
    header("Location: admin.php?page=daftar_siswa"); 
    exit(); // Penting untuk menghentikan script agar tidak ada output lain yang ditampilkan
}

$conn->close(); // Tutup koneksi jika sudah selesai
?>
