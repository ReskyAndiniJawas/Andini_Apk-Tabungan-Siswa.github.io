<?php
// Koneksi ke database
include 'koneksi.php';

// Query untuk mengambil data laporan
$query = "
    SELECT s.nama, s.kelas, 
    SUM(CASE WHEN t.jenis_transaksi = 'setor' THEN t.saldo ELSE 0 END) AS total_setoran,
    SUM(CASE WHEN t.jenis_transaksi = 'tarik' THEN t.saldo ELSE 0 END) AS total_penarikan,
    (SUM(CASE WHEN t.jenis_transaksi = 'setor' THEN t.saldo ELSE 0 END) - 
    SUM(CASE WHEN t.jenis_transaksi = 'tarik' THEN t.saldo ELSE 0 END)) AS saldo_akhir
    FROM transaksi t
    JOIN siswa s ON t.id_siswa = s.id_siswa
    GROUP BY s.id_siswa
    ORDER BY s.nama ASC
";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Tabungan Siswa</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
            font-size: 30px;
            font-weight: 600;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 15px;
            text-align: left;
            font-size: 16px;
        }
        th {
            background-color: #28a745; /* Mengganti dengan warna hijau Bootstrap */
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .btn-kembali {
            display: inline-block;
            padding: 12px 20px;
            background-color: #dc3545;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
            margin-top: 20px;
            font-size: 16px;
        }
        .btn-kembali:hover {
            background-color: #c82333;
        }
        .footer {
            text-align: center;
            color: #555;
            font-size: 14px;
            margin-top: 30px;
        }
        @media (max-width: 600px) {
            table, th, td {
                font-size: 14px;
            }
            .btn-kembali {
                width: 100%;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <h1>LAPORAN TABUNGAN SISWA</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th>Total Setoran</th>
                <th>Total Penarikan</th>
                <th>Saldo Akhir</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['kelas'] . "</td>";
                    echo "<td>Rp " . number_format($row['total_setoran'], 2, ',', '.') . "</td>";
                    echo "<td>Rp " . number_format($row['total_penarikan'], 2, ',', '.') . "</td>";
                    echo "<td>Rp " . number_format($row['saldo_akhir'], 2, ',', '.') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' style='text-align:center;'>Tidak ada data</td></tr>";
            }
            ?>
        </tbody>
    </table>


    <footer class="footer">
        <p>&copy; 2024 Tabungan Siswa</p>
    </footer>
</body>
</html>

<?php
// Menutup koneksi database
$conn->close();
?>
