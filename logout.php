<?php
session_start(); // Memulai session
session_unset(); // Menghapus semua variabel session
session_destroy(); // Menghancurkan session
header("Location: login.php"); // Arahkan kembali ke halaman login
exit(); // Pastikan script tidak dilanjutkan
?>
