<?php
// Koneksi ke database
$servername = "localhost"; // Ganti dengan nama server Anda
$username = "root"; // Ganti dengan username database Anda
$password = ""; // Ganti dengan password database Anda
$dbname = "tabungan_siswa"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data kelas
$sql = "SELECT id_kelas, nama_kelas, jurusan FROM kelas"; // Pastikan tabel dan kolom sudah benar
$result = $conn->query($sql);

// Variabel untuk pesan
$message = isset($_GET['message']) ? $_GET['message'] : '';

// HTML dan CSS untuk tampilan
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Kelas</title>
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
            color: #28a745; /* Ubah warna hijau di sini */
        }
        a:hover {
            text-decoration: underline;
        }
        .button {
            background-color: #28a745; /* Hijau terang sesuai dengan tombol di edit_siswa.php */
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
            background-color: #218838; /* Hijau gelap saat hover */
        }
        .action-button {
            color: #28a745; /* Ubah warna hijau di sini */
            font-weight: 600;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            background-color: transparent;
            cursor: pointer;
            transition: color 0.3s ease;
        }
        .action-button:hover {
            color: #218838; /* Hijau gelap saat hover */
        }
        .aksi-container {
            text-align: center; /* Pusatkan teks di tengah */
        }
        .aksi-header {
            text-align: center; /* Pusatkan header aksi */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><strong>Daftar Kelas</strong></h1> <!-- Membuat kata "Kelas" menjadi bold -->

        <!-- Tombol untuk menambah kelas -->
        <a href="add_class.php" class="button">Tambah Kelas</a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th class="aksi-header">Aksi</th> <!-- Pusatkan header aksi -->
                </tr>
            </thead>
            <tbody>
                <?php
                // Variabel untuk nomor urut
                $no = 1;

                // Tampilkan data kelas
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['nama_kelas']}</td>
                                <td>{$row['jurusan']}</td>
                                <td class='aksi-container'>
                                    <a href='edit_class.php?id={$row['id_kelas']}' class='action-button'>Edit</a> | 
                                    <a href='delete_class.php?id={$row['id_kelas']}' class='action-button' onclick='return confirm(\"Apakah anda yakin ingin menghapus data ini?\")'>Hapus</a>
                                </td>
                              </tr>";
                        $no++; // Increment nomor urut
                    }
                } else {
                    echo "<tr><td colspan='4'>Tidak ada data kelas</td></tr>";
                }

                // Tutup koneksi
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
