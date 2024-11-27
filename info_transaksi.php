<?php
// Konfigurasi database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "tabungan_siswa";

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $pass, $db);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Mengambil daftar siswa untuk dropdown
$siswa_query = "SELECT id_siswa, nama FROM siswa";
$siswa_result = $conn->query($siswa_query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Info Kas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin-top: 100px;
            padding: 40px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card {
            background-color: #f9f9f9;
            border: none;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            background-color: #4CAF50;
            color: white;
            text-align: center;
            font-size: 1.5rem;
            padding: 20px;
            border-radius: 10px 10px 0 0;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-control {
            border-radius: 8px;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        .form-control:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
        }
        .btn-success {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            font-size: 1.1rem;
            transition: background-color 0.3s;
        }
        .btn-success:hover {
            background-color: #45a049;
        }
        .btn {
            font-size: 1.1rem;
        }
        .form-control, .btn {
            height: 50px;
        }
        @media (max-width: 576px) {
            .container {
                margin-top: 50px;
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            Info Kas Siswa
        </div>
        <div class="card-body">
            <form method="GET" action="lihat_info_kas.php">
                <!-- Dropdown Siswa -->
                <div class="form-group">
                    <label for="id_siswa">Pilih Siswa:</label>
                    <select id="id_siswa" name="id_siswa" class="form-control" required>
                        <option value="">-- Pilih Siswa --</option>
                        <?php while ($row = $siswa_result->fetch_assoc()): ?>
                            <option value="<?php echo $row['id_siswa']; ?>">
                                <?php echo $row['nama']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                
                <!-- Input Tanggal Awal -->
                <div class="form-group">
                    <label for="start_date">Tanggal Awal:</label>
                    <input type="date" id="start_date" name="start_date" class="form-control" required>
                </div>
                
                <!-- Input Tanggal Akhir -->
                <div class="form-group">
                    <label for="end_date">Tanggal Akhir:</label>
                    <input type="date" id="end_date" name="end_date" class="form-control" required>
                </div>
                
                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-success mt-3">Lihat Info Kas</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
