<?php 
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_kelas = $_POST['nama_kelas'];
    $jurusan = $_POST['jurusan'];

    // Cek apakah kelas dengan nama dan jurusan yang sama sudah ada
    $query_check = "SELECT * FROM kelas WHERE nama_kelas = ? AND jurusan = ?";
    $stmt_check = $conn->prepare($query_check);
    $stmt_check->bind_param("ss", $nama_kelas, $jurusan);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Jika kelas sudah ada
        echo "<script>alert('Kelas dengan nama \"$nama_kelas\" dan jurusan \"$jurusan\" sudah ada!');</script>";
    } else {
        // Jika kelas belum ada, maka tambahkan
        $query = "INSERT INTO kelas (nama_kelas, jurusan) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $nama_kelas, $jurusan);
        
        if ($stmt->execute()) {
            header("Location: admin.php?page=class&message=Kelas dan jurusan berhasil ditambahkan!");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // Tutup statement
    $stmt_check->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kelas</title>
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
        h1 {
            text-align: center;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
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
    <div class="container">
        <h1>Tambah Kelas</h1>
        <form method="POST">
            <label for="nama_kelas">Nama Kelas:</label>
            <input type="text" id="nama_kelas" name="nama_kelas" required>

            <label for="jurusan">Jurusan:</label>
            <input type="text" id="jurusan" name="jurusan" required>

            <div class="form-buttons">
                <a href="admin.php?page=class" class="back-btn">Kembali</a>
                <button type="submit" class="submit-btn">Simpan</button>
            </div>
        </form>
    </div>
</body>
</html>
