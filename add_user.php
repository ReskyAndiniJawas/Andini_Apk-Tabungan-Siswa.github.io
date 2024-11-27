<?php
// Menghubungkan ke database
include 'koneksi.php';

// Mengambil data siswa dari database untuk dropdown
$query_siswa = "SELECT id_siswa, nama FROM siswa";
$result_siswa = $conn->query($query_siswa);

// Cek jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $hashed_password = md5($password); // Meng-hash password menggunakan MD5

    // Insert data user
    if ($role == 'siswa') {
        $id_siswa = $_POST['id_siswa'];
        // Pastikan query ini benar
        $insert_query = "INSERT INTO user (username, password, role, id_siswa) VALUES ('$username', '$hashed_password', '$role', '$id_siswa')";
    } else {
        $insert_query = "INSERT INTO user (username, password, role) VALUES ('$username', '$hashed_password', '$role')";
    }

    if ($conn->query($insert_query) === TRUE) {
        echo "<script>alert('User berhasil ditambahkan!'); window.location.href = 'admin.php?page=user';</script>";
        exit;
    } else {
        echo "Error: " . $insert_query . "<br>" . $conn->error; // Tampilkan error jika ada
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); }
        h1 { text-align: center; color: #333; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"], select { width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; }
        
        /* Tampilan tombol */
        .form-buttons { display: flex; gap: 10px; }
        .back-btn, .submit-btn { flex: 1; padding: 10px; border-radius: 4px; cursor: pointer; border: none; font-size: 14px; }
        .submit-btn { background-color: #28a745; color: white; }
        .submit-btn:hover { background-color: #218838; }
        .back-btn { background-color: #dc3545; color: white; }
        .back-btn:hover { background-color: #c82333; }
    </style>
    <script>
        function toggleSiswaSelect() {
            const roleSelect = document.getElementById("role");
            const siswaSelect = document.getElementById("id_siswa_select");
            if (roleSelect.value === "siswa") {
                siswaSelect.style.display = "block"; // Tampilkan select siswa
            } else {
                siswaSelect.style.display = "none"; // Sembunyikan select siswa
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <h1>Tambah User</h1>
        <form method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="role">Role:</label>
            <select name="role" id="role" onchange="toggleSiswaSelect()" required>
                <option value="admin">Admin</option>
                <option value="siswa">Siswa</option>
            </select>

            <div id="id_siswa_select" style="display: none;">
                <label for="id_siswa">Pilih Siswa:</label>
                <select name="id_siswa">
                    <?php
                    if ($result_siswa->num_rows > 0) {
                        while ($row = $result_siswa->fetch_assoc()) {
                            echo "<option value='{$row['id_siswa']}'>{$row['nama']} (ID: {$row['id_siswa']})</option>";
                        }
                    } else {
                        echo "<option value=''>Tidak ada siswa</option>";
                    }
                    ?>
                </select>
            </div>                   

            <div class="form-buttons">
                <button type="button" class="back-btn" onclick="window.location.href='admin.php?page=user'">Kembali</button>
                <button type="submit" class="submit-btn">Simpan</button>
            </div>
        </form>
    </div>

    <script>
        // Memanggil fungsi untuk menampilkan dropdown siswa saat halaman pertama kali dimuat
        toggleSiswaSelect();
    </script>
</body>
</html>
