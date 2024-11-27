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

// Memproses form jika ada
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $username = $_POST['username'];
    $role = $_POST['role'];

    // Update data user
    $query = "UPDATE user SET username='$username', role='$role' WHERE id_user='$id_user'";
    if ($conn->query($query) === TRUE) {
        header("Location: admin.php?page=user&message=Data user berhasil diupdate!");
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}

// Mendapatkan data user berdasarkan id
$id_user = $_GET['id'];
$query = "SELECT username, role FROM user WHERE id_user='$id_user'";
$result = $conn->query($query);
$user = $result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #28a745; /* Warna hijau */
            color: white;
            border: none;
            padding: 8px; /* Ukuran tombol lebih kecil */
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 14px; /* Ukuran font tombol */
        }
        input[type="submit"]:hover {
            background-color: #218838; /* Warna hijau lebih gelap saat hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form method="POST">
            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo $user['username']; ?>" required>
            <label for="role">Role:</label>
            <select name="role" required>
                <option value="admin" <?php if ($user['role'] == 'admin') echo 'selected'; ?>>Admin</option>
                <option value="siswa" <?php if ($user['role'] == 'siswa') echo 'selected'; ?>>Siswa</option>
            </select>
            <input type="submit" value="Simpan">
        </form>
    </div>
</body>
</html>

