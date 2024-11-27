<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <title>Login - Tabungan Siswa</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(to bottom, rgba(57, 173, 219, .25), rgba(42, 60, 87, .4)),
                        linear-gradient(135deg, #670d10 0%, #092756 100%);
            color: #fff;
        }

        .login {
            width: 350px;
            padding: 30px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
            backdrop-filter: blur(10px);
        }

        .login h1 {
            font-size: 26px;
            margin-bottom: 24px;
            color: #fff;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4);
        }

        .login input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            color: #fff;
            font-size: 16px;
            outline: none;
            transition: background 0.3s, box-shadow 0.3s, border 0.3s;
        }

        .login input::placeholder {
            color: #e0e0e0;
        }

        .login input:focus {
            background: rgba(255, 255, 255, 0.3);
            box-shadow: 0 4px 10px rgba(255, 255, 255, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }

        .btn {
            width: 100%;
            padding: 12px;
            background: linear-gradient(to right, #4a77d4, #6a93cb);
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease, transform 0.2s;
            margin-top: 10px;
        }

        .btn:hover {
            background: linear-gradient(to left, #4a77d4, #6a93cb);
            transform: translateY(-2px);
        }

        .btn:active {
            transform: translateY(6px); /* Memberikan efek gerakan saat tombol ditekan */
        }

        .alert {
            font-size: 14px;
            color: #ff6b6b;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login">
        <h1>Login</h1>
        <?php
        session_start();

        $host = "localhost";
        $user = "root";
        $pass = "";
        $db = "tabungan_siswa";

        $conn = new mysqli($host, $user, $pass, $db);

        if ($conn->connect_error) {
            die("Koneksi gagal: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $username = $_POST['username'];
            $password = md5($_POST['password']);
            $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();
                $_SESSION['user'] = $data['username'];
                $_SESSION['role'] = $data['role'];
                $_SESSION['id_user'] = $data['id_user'];

                if ($data['role'] == 'siswa') {
                    $id_siswa = $data['id_siswa'];
                    $siswa_data = $conn->query("SELECT nama FROM siswa WHERE id_siswa='$id_siswa'");
                    $siswa = $siswa_data->fetch_assoc();
                    $_SESSION['id_siswa'] = $id_siswa;
                    $_SESSION['nama_siswa'] = $siswa['nama'];
                    echo '<script>alert("Selamat Datang Siswa!"); location.href="siswa_dashboard.php";</script>';
                } else {
                    echo '<script>alert("Selamat Datang Admin!"); location.href="admin.php?page=home";</script>';
                }
            } else {
                echo '<div class="alert">Maaf, Username atau Password Salah!</div>';
            }
        }
        ?>
        <form method="post">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" class="btn">Let me in</button>
        </form>
    </div>
</body>
</html>
