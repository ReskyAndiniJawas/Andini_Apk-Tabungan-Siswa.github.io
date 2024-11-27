<?php
include 'koneksi.php';

$id_kelas = $_GET['id'];
$query = "SELECT * FROM kelas WHERE id_kelas = '$id_kelas'";
$result = $conn->query($query);
$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kelas = $_POST['nama_kelas'];
    $jurusan = $_POST['jurusan'];

    $query = "UPDATE kelas SET nama_kelas = '$nama_kelas', jurusan = '$jurusan' WHERE id_kelas = '$id_kelas'";

    if ($conn->query($query) === TRUE) {
        header("Location: admin.php?page=class&message=Kelas berhasil diperbarui!");
        exit();
    } else {
        echo "Error: " . $query . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .submit-btn,
        .back-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }
        .submit-btn {
            background-color: #28a745; /* Warna hijau */
            color: white;
        }
        .back-btn {
            background-color: #dc3545; /* Warna merah */
            color: white;
        }
        .submit-btn:hover {
            background-color: #218838; /* Warna hijau gelap */
            transform: scale(1.05); /* Efek zoom */
        }
        .back-btn:hover {
            background-color: #c82333; /* Warna merah gelap */
            transform: scale(1.05); /* Efek zoom */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>Edit Kelas</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nama_kelas" class="form-label">Nama Kelas</label>
                <input type="text" class="form-control" id="nama_kelas" name="nama_kelas" value="<?= htmlspecialchars($row['nama_kelas']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="jurusan" class="form-label">Jurusan</label>
                <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?= htmlspecialchars($row['jurusan']); ?>" required>
            </div>
            <div class="form-buttons">
                <a href="admin.php?page=class" class="back-btn">Kembali</a>
                <button type="submit" class="submit-btn">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
