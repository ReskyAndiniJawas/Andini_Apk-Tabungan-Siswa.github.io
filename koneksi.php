<?php
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
//  else {
//     echo "Koneksi berhasil ke database tabungan_siswa!";
// }

// Tutup koneksi (opsional, jika dibutuhkan)
// $conn->close();
?>
