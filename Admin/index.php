<?php
include "session.php";
include "../koneksi.php";

// Hitung jumlah slide carousel
$querycarousel = mysqli_query($conn, "SELECT * FROM carousel_slides WHERE status='active'");
$jumlahcarousel = mysqli_num_rows($querycarousel);

// Hitung jumlah data nilai (contoh)
$querynilai = mysqli_query($conn, "SELECT COUNT(*) AS total_nilai FROM nilai");
$datanilai = mysqli_fetch_assoc($querynilai);
$jumlahnilai = $datanilai['total_nilai'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../bootstrap-5.2.3-dist\bootstrap-5.2.3-dist\css\bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>

<style>
    body {
        background: #f4f6f9;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .summary-box {
        border-radius: 20px;
        color: #fff;
        padding: 25px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }

    .summary-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .summary-carousel {
        background: linear-gradient(135deg, #6b0a3a, #a3145d);
    }

    .summary-produk {
        background: linear-gradient(135deg, #0a516b, #117f9b);
    }

    .summary-nilai {
        background: linear-gradient(135deg, #d39e00, #ffc107);
    }

    .summary-box i {
        opacity: 0.7;
    }

    .summary-box h3 {
        font-size: 1.8rem;
        margin-bottom: 5px;
    }

    .summary-box p {
        margin: 0;
    }

    .summary-box .btn {
        border-radius: 30px;
        font-size: 0.9rem;
        padding: 6px 16px;
        margin-top: 10px;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
    }

    h2 {
        font-weight: 600;
    }
</style>

<body>
    <?php include "navbar.php"; ?>

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <i class="fas fa-home"></i> Home
                </li>
            </ol>
        </nav>
        <h2>Halo <?php echo $_SESSION['username'] ?></h2>

        <div class="row mt-4">

            <!-- Carousel -->
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="summary-box summary-carousel">
                    <div class="d-flex justify-content-between">
                        <i class="fas fa-images fa-5x text-white-50"></i>
                        <div class="text-end">
                            <h3>Slide</h3>
                            <p class="fs-5 mb-1"><?php echo $jumlahcarousel; ?> Aktif</p>
                            <a href="carousel.php" class="btn btn-light text-dark">Kelola Slide</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Absensi -->
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="summary-box summary-produk">
                    <div class="d-flex justify-content-between">
                        <i class="fas fa-calendar-check fa-5x text-white-50"></i>
                        <div class="text-end">
                            <h3>Absensi</h3>
                            <p class="fs-5 mb-1">Lihat Data</p>
                            <a href="absensi.php" class="btn btn-light text-dark">Kelola Absensi</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buku Nilai -->
            <div class="col-lg-4 col-md-6 col-12 mb-4">
                <div class="summary-box summary-nilai">
                    <div class="d-flex justify-content-between">
                        <i class="fas fa-book fa-5x text-white-50"></i>
                        <div class="text-end">
                            <h3>Buku Nilai</h3>
                            <p class="fs-5 mb-1"><?php echo $jumlahnilai; ?> Data</p>
                            <a href="admin_nilai.php" class="btn btn-light text-dark">Kelola Nilai</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <script src="../bootstrap-5.2.3-dist/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>
