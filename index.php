<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Solusi modern untuk mengelola tabungan siswa." />
    <meta name="author" content="Tabunggo Team" />
    <title>TABUNGGO - Tabungan Siswa Masa Kini</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap Icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic" rel="stylesheet" type="text/css" />
    <!-- SimpleLightbox plugin CSS-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/SimpleLightbox/2.1.0/simpleLightbox.min.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
    <style>
        /* Navbar */
        .navbar {
            background-color: #4CAF50; /* Hijau lembut */
        }
        .navbar .nav-link, .navbar-brand {
            color: #ffffff !important;
        }

        /* Warna hijau untuk tautan yang sedang aktif atau ditekan */
        .nav-link.active, .nav-link:focus {
            color: #4CAF50 !important; /* Hijau saat tautan ditekan atau aktif */
        }

        /* Warna putih saat tidak ditekan */
        .nav-link {
            color: #ffffff !important;
        }

        /* Warna putih saat hover */
        .nav-link:hover {
            color: #ffffff !important;
        }

        /* Header */
        .masthead {
            background-color: #4CAF50; /* Hijau lembut */
        }
        .masthead h1, .masthead p {
            color: #ffffff;
        }

        /* Fitur */
        .text-primary {
            color: #4CAF50 !important; /* Mengubah warna ikon */
        }

        /* Tombol */
        .btn-primary {
            background-color: #4CAF50;
            border-color: #4CAF50;
        }
        .btn-primary:hover {
            background-color: #388E3C;
            border-color: #388E3C;
        }

        /* Tentang Kami */
        .bg-primary {
            background-color: #4CAF50 !important; /* Mengubah bg-primary ke hijau */
        }

        /* Additional Styles */
        .section-title {
            margin-bottom: 50px;
            font-weight: bold;
            color: #333;
            text-transform: uppercase;
        }

        .fitur-icon {
            font-size: 2.5rem;
            color: #28a745;
            margin-bottom: 15px;
        }

        /* Card styles for features */
        .fitur-card {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
            background-color: #fff; /* Tambahkan warna latar belakang putih */
        }

        .fitur-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        /* Footer */
        footer {
            background-color: #66BB6A;
            color: #000000; /* Ubah warna teks footer menjadi hitam */
            padding: 20px 0; /* Tambahkan padding */
            text-align: center; /* Pusatkan footer */
        }

        .footer-links a {
            color: #000000; /* Ubah warna tautan di footer menjadi hitam */
            margin: 0 10px;
            text-decoration: none;
        }

        .footer-links a:hover {
            text-decoration: underline; /* Tambahkan efek hover */
        }
    </style>
</head>
<body id="page-top">
    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand" href="#page-top">TABUNGGO</a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#tentang_kami">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="#fitur_unggulan">Fitur Unggulan</a></li>
                    <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Masthead-->
    <header class="masthead" href="#home">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 h-100 align-items-center justify-content-center text-center">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">Solusi Cerdas untuk Tabungan Siswa Digital</h1>
                    <hr class="divider" />
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">Kelola tabungan dengan lebih canggih dan aman. Ciptakan kebiasaan menabung sejak dini untuk masa depan yang gemilang!</p>
                    <a class="btn btn-primary btn-xl" href="login.php">Gabung Sekarang</a>
                </div>
            </div>
        </div>
    </header>
    <!-- About-->
    <section class="page-section bg-primary" id="tentang_kami">
        <div class="container px-4 px-lg-5">
            <div class="row gx-4 gx-lg-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="text-white mt-0">Aplikasi Terdepan untuk Pengelolaan Tabungan Siswa</h2>
                    <hr class="divider divider-light" />
                    <p class="text-white-75 mb-4">Dengan aplikasi ini, siswa dapat mengatur tabungan dengan mudah dan aman. Mulailah perjalanan finansial sejak dini untuk menciptakan masa depan yang cerah.</p>
                    <a class="btn btn-light btn-xl" href="#fitur_unggulan">Jelajahi Fitur</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section class="page-section" id="fitur_unggulan">
        <div class="container">
            <h2 class="section-title text-center">Fitur Unggulan Kami</h2>
            <div class="row text-center">
                <div class="col-md-4">
                    <div class="fitur-card">
                        <i class="fitur-icon bi bi-shield-lock"></i>
                        <h4 class="mt-3">Keamanan Data</h4>
                        <p>Data tabungan siswa tersimpan aman dan terlindungi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fitur-card">
                        <i class="fitur-icon bi bi-speedometer2"></i>
                        <h4 class="mt-3">Cepat dan Efisien</h4>
                        <p>Pengelolaan data tabungan lebih cepat dan mudah.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="fitur-card">
                        <i class="fitur-icon bi bi-bar-chart-line"></i>
                        <h4 class="mt-3">Laporan Lengkap</h4>
                        <p>Menyediakan laporan transaksi yang lengkap dan transparan.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer-->
    <footer class="py-4" id="footer">
        <div class="container px-4 px-lg-5">
            <div class="text-center">© 2024 TABUNGGO.</div>
        </div>
    </footer>

    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>
</html>

