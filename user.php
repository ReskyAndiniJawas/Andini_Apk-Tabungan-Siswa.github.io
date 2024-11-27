<?php
// Menghubungkan ke database
include 'koneksi.php';

// Mengambil data user dari database
$query = "SELECT * FROM user";
$result = $conn->query($query);

// Menangkap pesan dari query string
$message = '';
if (isset($_GET['message'])) {
    $message = $_GET['message'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman User</title>
    <script>
        // Menampilkan alert jika ada pesan
        window.onload = function() {
            <?php if ($message): ?>
                alert("<?php echo $message; ?>");
            <?php endif; ?>
        };
    </script>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
        }
        .container {
            width: 800px;
            margin: auto;
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: #28a745; /* Menggunakan warna hijau dari class.php */
        }
        a:hover {
            text-decoration: underline;
        }
        .button {
            background-color: #28a745; /* Menggunakan warna hijau dari class.php */
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            margin: 10px 0;
            display: block;
            text-align: center;
            width: 125px;
            margin-left: auto;
        }
        .button:hover {
            background-color: #218838; /* Warna hijau gelap saat hover dari class.php */
        }
        .action-button {
            color: #28a745; /* Menggunakan warna hijau dari class.php */
            font-weight: 600;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: transparent;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .action-button:hover {
            color: #218838; /* Warna hijau gelap saat hover dari class.php */
        }
        .aksi-container {
            text-align: center; /* Memusatkan teks dalam div */
        }
        .aksi-header {
            text-align: center; /* Memusatkan teks "Aksi" */
            padding-right: 40px; /* Geser ke kanan sedikit */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><strong>Daftar User</strong></h1>

        <!-- Tombol untuk menambah user -->
        <a href="add_user.php" class="button">Tambah User</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th class="aksi-header">Aksi</th>
                    <th>Change Password</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1; // Nomor urut
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$no}</td>";
                        echo "<td>{$row['username']}</td>";
                        echo "<td>{$row['role']}</td>";
                        echo "<td class='aksi-container'>
                                <a href='edit_user.php?id={$row['id_user']}' class='action-button'>Edit</a> | 
                                <a href='delete_user.php?id={$row['id_user']}' class='action-button' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\")'>Hapus</a>
                              </td>";
                        echo "<td>
                                <a href='change_password.php?id={$row['id_user']}' class='action-button'>Password</a>
                              </td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada data user</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
