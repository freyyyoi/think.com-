<?php // tentang_kami.php 
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tentang Kami - Think Indonesia</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: url('images/clouds.jpg') repeat-x center top;
      background-size: cover;
      animation: moveClouds 60s linear infinite;
      scroll-behavior: smooth;
    }

    @keyframes moveClouds {
      from {
        background-position: 0 0;
      }

      to {
        background-position: -2000px 0;
      }
    }

    /* Navbar */
    .navbar {
      backdrop-filter: blur(14px);
      background: rgba(255, 255, 255, 0.9) !important;
      box-shadow: 0 2px 15px rgba(0, 0, 0, 0.05);
      z-index: 1030;
    }

    .navbar-brand img {
      height: 45px;
      transition: transform .3s;
    }

    .navbar-brand img:hover {
      transform: scale(1.07);
    }

    .nav-link {
      font-weight: 500;
      margin: 0 6px;
      transition: all .3s;
    }

    .nav-link:hover {
      color: #eab308 !important;
    }

    /* Sub-navbar */
    .sub-navbar {
      position: sticky;
      top: 65px;
      /* tepat di bawah navbar utama */
      z-index: 1029;
      background: rgba(255, 255, 255, 0.95);
      padding: 8px 14px;
      border-radius: 0;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    }

    .sub-navbar .nav-pills {
      gap: 10px;
      justify-content: center;
      flex-wrap: nowrap;
      overflow-x: auto;
      white-space: nowrap;
    }

    .sub-navbar .nav-link {
      font-weight: 500;
      color: #555;
      border-radius: 30px;
      transition: all .3s;
      padding: 10px 18px;
      display: flex;
      align-items: center;
    }

    .sub-navbar .nav-link i {
      font-size: 18px;
      color: #eab308;
      margin-right: 8px;
      transition: transform .3s;
    }

    .sub-navbar .nav-link:hover i {
      transform: scale(1.2);
    }

    .sub-navbar .nav-link:hover,
    .sub-navbar .nav-link.active {
      background: #eab308;
      color: #fff !important;
    }

    /* Title */
    .title-badge {
      font-weight: 800;
      font-size: 42px;
      text-align: center;
      margin: 70px 0 40px;
      color: #eab308;
      text-transform: uppercase;
      letter-spacing: 2px;
    }

    /* Section card style */
    .section {
      width: 100%;
      padding: 60px 40px;
      background: #fff;
      border-radius: 24px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
      margin: 50px auto;
      max-width: 1050px;
      transition: transform .3s, box-shadow .3s;
      scroll-margin-top: 140px;
      /* biar ga ketutup navbar */
    }

    .section:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .section h2 {
      font-size: 28px;
      font-weight: 700;
      color: #eab308;
      margin-bottom: 25px;
    }

    .section p,
    .section ol {
      font-size: 17px;
      color: #444;
      line-height: 1.8;
      text-align: justify;
    }

    .section ol li {
      margin-bottom: 12px;
    }

    /* Struktur Organisasi */
    #struktur img {
      border-radius: 16px;
      border: 2px solid #eee;
      cursor: pointer;
      transition: transform .3s, box-shadow .3s;
    }

    #struktur img:hover {
      transform: scale(1.03);
      box-shadow: 0 12px 30px rgba(0, 0, 0, 0.18);
    }

    /* Footer */
    .footer {
      padding: 24px 0 42px;
      color: var(--muted);
    }

    .footer__inner {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 16px;
      border-top: 1px solid rgba(0, 0, 0, .08);
      padding-top: 16px;
    }

    @media (max-width: 600px) {
      .footer__inner {
        flex-direction: column;
        text-align: center;
      }
    }

    .footer__links {
      display: flex;
      gap: 14px;
    }

    .footer__links a {
      color: inherit;
    }

    .footer__links a:hover {
      color: var(--ink);
    }
  </style>
</head>

<body>

  <?php
    include "navbar.php";
  ?>

  <!-- SUB NAVBAR (langsung dibawah navbar utama) -->
  <nav class="sub-navbar">
    <div class="container d-flex justify-content-center">
      <ul class="nav nav-pills px-2">
        <li class="nav-item">
          <a class="nav-link" href="#visi"><i class="bi bi-lightbulb"></i> Visi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#misi"><i class="bi bi-flag"></i> Misi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#struktur"><i class="bi bi-diagram-3"></i> Struktur</a>
        </li>
      </ul>
    </div>
  </nav>

  <!-- JUDUL -->
  <div class="title-badge">Tentang Kami</div>

  <!-- VISI -->
  <section class="section" id="visi">
    <h2><i class="bi bi-lightbulb"></i> Visi Think Indonesia</h2>
    <p>
      Untuk menjadi lembaga pendidikan non-formal berbasis komunitas dan informal homeschooling,
      yang selalu membimbing dan mengarahkan generasi penerus Indonesia agar mereka siap secara
      psikologis, keuangan, dan teknologi. Bahkan sebelum mereka lulus dengan memiliki pengalaman
      yang kuat, tingkat laku yang baik dan memahami tentang nilai kehidupan.
    </p>
  </section>

  <!-- MISI -->
  <section class="section" id="misi">
    <h2><i class="bi bi-flag"></i> Misi Think Indonesia</h2>
    <ol>
      <li>Menjadi lembaga pendidikan non-formal yang terbaik di Indonesia</li>
      <li>Menghasilkan generasi penerus Indonesia yang siap secara psikologi, ekonomi, dan teknologi</li>
      <li>Mendampingi dan membimbing para siswa agar siap menjadi seorang pemilik usaha ataupun profesional di bidangnya</li>
      <li>Menjadi pendamping generasi muda Indonesia yang kuat secara pengalaman, tingkah laku, etika, dan memahami nilai kehidupan</li>
    </ol>
  </section>

  <!-- STRUKTUR ORGANISASI -->
  <section class="section" id="struktur">
    <h2><i class="bi bi-diagram-3"></i> Struktur Organisasi</h2>
    <img src="img/struktur.jpeg" alt="Struktur Organisasi" class="img-fluid" data-bs-toggle="modal" data-bs-target="#strukturModal">
  </section>

  <!-- Modal Zoom Struktur -->
  <div class="modal fade" id="strukturModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content bg-transparent border-0">
        <img src="img/struktur.jpeg" alt="Struktur Organisasi" class="img-fluid rounded shadow">
      </div>
    </div>
  </div>

  <?php
    include "footer.php";
  ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>