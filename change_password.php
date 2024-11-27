<?php
// Menghubungkan ke database
include 'koneksi.php';

// Pesan error jika ada masalah
$message = "";

// Cek jika ada ID yang dikirimkan
if (isset($_GET['id'])) {
    $id_user = $_GET['id'];

    // Cek jika form disubmit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $new_password = $_POST['new_password'];
        $retype_password = $_POST['retype_password'];

        // Cek apakah password dan konfirmasi password cocok
        if ($new_password === $retype_password) {
            $hashed_password = md5($new_password); // Hash password baru menggunakan MD5

            // Update password user
            $update_query = "UPDATE user SET password='$hashed_password' WHERE id_user='$id_user'";
            if ($conn->query($update_query) === TRUE) {
                echo "<script>alert('Password berhasil diupdate!'); window.location.href = 'admin.php?page=user';</script>";
                exit;
            } else {
                $message = "Error: " . $conn->error;
            }
        } else {
            // Jika password dan konfirmasi password tidak cocok
            echo "<script>alert('Password dan konfirmasi password tidak cocok!');</script>";
        }
    }
} else {
    echo "ID user tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password</title>
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
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-buttons {
            display: flex;
            justify-content: space-between;
        }
        .submit-btn, .back-btn {
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            width: 48%;
            text-align: center;
            font-size: 14px;
        }
        .submit-btn {
            background-color: #28a745;
        }
        .back-btn {
            background-color: #dc3545;
        }
        .submit-btn:hover, .back-btn:hover {
            opacity: 0.8;
        }
        .message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ubah Password</h1>

        <!-- Pesan error jika ada -->
        <?php if ($message != "") { echo "<p class='message'>$message</p>"; } ?>

        <form method="POST" onsubmit="return validatePassword()">
            <input type="hidden" name="id_user" value="<?php echo $id_user; ?>">

            <label for="new_password">Password Baru:</label>
            <input type="password" name="new_password" id="new_password" required>

            <label for="retype_password">Konfirmasi Password:</label>
            <input type="password" name="retype_password" id="retype_password" required>

            <div class="form-buttons">
                <button type="submit" class="submit-btn">Simpan</button>
                <a href="admin.php?page=user" class="back-btn">Kembali</a>
            </div>
        </form>
    </div>

    <script>
        // Fungsi untuk memvalidasi password dan konfirmasi password di sisi klien
        function validatePassword() {
            var newPassword = document.getElementById('new_password').value;
            var retypePassword = document.getElementById('retype_password').value;

            if (newPassword !== retypePassword) {
                alert('Password dan konfirmasi password tidak cocok!');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
