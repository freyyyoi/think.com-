<?php
include "koneksi.php";
?>

<!doctype html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Think Indonesia School</title>
  <link rel="icon" type="image/png" sizes="23x23" href="img/this-school-new.png">


</head>
<link rel="stylesheet" href="styles.css">
<link rel="stylesheet" href="bootstrap-5.2.3-dist\bootstrap-5.2.3-dist\css\bootstrap.min.css">
<link rel="stylesheet" href="fontawesome/css/all.min.css">

<body>
  <?php
    include "navbar.php";
  ?>
  <!-- CAROUSEL -->
  <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">

    <div class="carousel-inner">
      <?php
      $result = mysqli_query($conn, "SELECT * FROM carousel_slides WHERE status='active' ORDER BY id DESC");
      $isActive = true;
      while ($row = mysqli_fetch_assoc($result)) {
      ?>
        <div class="carousel-item <?php if ($isActive) {
                                    echo 'active';
                                    $isActive = false;
                                  } ?>">
          <img src="uploads/<?php echo $row['image']; ?>" class="d-block img-fluid rounded-4" alt="Slide">
          <div class="carousel-caption d-none d-md-block">
            <h5><?php echo htmlspecialchars($row['title']); ?></h5>
            <p><?php echo htmlspecialchars($row['description']); ?></p>
          </div>
        </div>
      <?php } ?>
    </div>

    <!-- Control -->
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
      <span class="carousel-control-prev-icon"></span>
      <span class="visually-hidden">Sebelumnya</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
      <span class="carousel-control-next-icon"></span>
      <span class="visually-hidden">Berikutnya</span>
    </button>
  </div>

  <!-- SECTION: TUGAS -->
  <div id="rp" class="container my-5">
    <h2 class="text-center mb-4">RUANG PEMBELAJARAN</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow h-100 text-center">
          <div class="card-body">
            <h5 class="btn btn-warning rounded-pill">Paket A/SD</h5>
            <img src="img/paket1.jpg" class="img-fluid my-3" alt="Paket A">
            <a href="#" class="btn btn-outline-dark">Lihat Tugas</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow h-100 text-center">
          <div class="card-body">
            <h5 class="btn btn-warning rounded-pill">Paket B/SMP</h5>
            <img src="img/paket1.jpg" class="img-fluid my-3" alt="Paket B">
            <a href="#" class="btn btn-outline-dark">Lihat Tugas</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow h-100 text-center">
          <div class="card-body">
            <h5 class="btn btn-warning rounded-pill">Paket C/SMA</h5>
            <img src="img/paket1.jpg" class="img-fluid my-3" alt="Paket C">
            <a href="#" class="btn btn-outline-dark">Lihat Tugas</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SECTION: MODUL -->
  <div id="modul" class="container my-5">
    <h2 class="text-center mb-4">MODUL</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow h-100 text-center">
          <div class="card-body">
            <h5 class="btn btn-warning rounded-pill">Paket A/SD</h5>
            <img src="img/paket1.jpg" class="img-fluid my-3" alt="Paket A">
            <a href="modul_A.php" class="btn btn-outline-dark">Lihat Modul</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow h-100 text-center">
          <div class="card-body">
            <h5 class="btn btn-warning rounded-pill">Paket B/SMP</h5>
            <img src="img/paket1.jpg" class="img-fluid my-3" alt="Paket B">
            <a href="#" class="btn btn-outline-dark">Lihat Modul</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow h-100 text-center">
          <div class="card-body">
            <h5 class="btn btn-warning rounded-pill">Paket C/SMA</h5>
            <img src="img/paket1.jpg" class="img-fluid my-3" alt="Paket C">
            <a href="#" class="btn btn-outline-dark">Lihat Modul</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- SECTION: PRESENTASI -->
  <div id="presentasi" class="container my-5">
    <h2 class="text-center mb-4">PRESENTASI</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow h-100 text-center">
          <div class="card-body">
            <h5 class="btn btn-warning rounded-pill">Paket A/SD</h5>
            <img src="img/paket1.jpg" class="img-fluid my-3" alt="Paket A">
            <a href="#" class="btn btn-outline-dark">Lihat Presentasi</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow h-100 text-center">
          <div class="card-body">
            <h5 class="btn btn-warning rounded-pill">Paket B/SMP</h5>
            <img src="img/paket1.jpg" class="img-fluid my-3" alt="Paket B">
            <a href="#" class="btn btn-outline-dark">Lihat Presentasi</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow h-100 text-center">
          <div class="card-body">
            <h5 class="btn btn-warning rounded-pill">Paket C/SMA</h5>
            <img src="img/paket1.jpg" class="img-fluid my-3" alt="Paket C">
            <a href="#" class="btn btn-outline-dark">Lihat Presentasi</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php
  include "footer.php";
  ?>

  <!-- Tombol Popup WhatsApp -->
  <div class="wa-popup" id="waPopup">
    <div class="wa-content">
      <span class="wa-close" onclick="document.getElementById('waPopup').style.display='none'">&times;</span>
      <p>Butuh bantuan? Chat kami di WhatsApp!</p>
      <a href="https://wa.me/6281231947742" target="_blank" class="wa-btn">Chat WhatsApp</a>
    </div>
  </div>

  <!-- Tombol Floating -->
  <div class="wa-float" onclick="document.getElementById('waPopup').style.display='block'">
    <i class="fab fa-whatsapp fa-2x text-success"></i>
  </div>

  
  <script src="bootstrap-5.2.3-dist\bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
  <script src="fontawesome/js/all.min.js"></script>
</body>

</html>