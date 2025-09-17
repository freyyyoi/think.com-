<?php
include "session.php";
include "../koneksi.php";

// Ambil semua data slide
$query = mysqli_query($conn, "SELECT * FROM carousel_slides ORDER BY sort_order ASC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Carousel</title>
  <link rel="stylesheet" href="../bootstrap-5.2.3-dist\bootstrap-5.2.3-dist\css\bootstrap.min.css">
  <link rel="stylesheet" href="../fontawesome/css/all.min.css">
</head>

<body>
  <?php include "navbar.php"; ?>

  <div class="container mt-4">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Kelola Carousel</li>
      </ol>
    </nav>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3>Daftar Carousel Slides</h3>
      <a href="carousel_tambah.php" class="btn btn-success"><i class="fas fa-plus"></i> Tambah Slide</a>
    </div>

    <table class="table table-bordered table-hover">
      <thead class="table-dark">
        <tr>
          <th>#</th>
          <th>Judul</th>
          <th>Deskripsi</th>
          <th>Gambar</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        if (mysqli_num_rows($query) > 0) {
          $no = 1;
          while ($row = mysqli_fetch_assoc($query)) { ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['title']); ?></td>
              <td><?= htmlspecialchars($row['description']); ?></td>
              <td>
                <?php if ($row['image']) { ?>
                  <img src="../uploads/<?= $row['image']; ?>" alt="" width="100">
                <?php } else { ?>
                  <span class="text-muted">No Image</span>
                <?php } ?>
              </td>
              <td>
                <?php if ($row['status'] == 'active') { ?>
                  <span class="badge bg-success">Aktif</span>
                <?php } else { ?>
                  <span class="badge bg-secondary">Nonaktif</span>
                <?php } ?>
              </td>
              <td>
                <a href="carousel_edit.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                <a href="carousel_hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus slide ini?')" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a>
              </td>
            </tr>
          <?php }
        } else { ?>
          <tr>
            <td colspan="7" class="text-center">Belum ada slide carousel</td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <script src="../bootstrap-5.2.3-dist\bootstrap-5.2.3-dist\js\bootstrap.bundle.min.js"></script>
  <script src="../fontawesome/js/all.min.js"></script>
</body>

</html>