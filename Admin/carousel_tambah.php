<?php
include "session.php";
include "../koneksi.php";

// Proses form jika disubmit
if(isset($_POST['simpan'])){
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status      = $_POST['status'];
    $sort_order  = (int) $_POST['sort_order'];

    // Proses upload gambar
    $image = "";
    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ""){
        $target_dir = "../uploads/";
        $image = time() . "_" . basename($_FILES['image']['name']);
        $target_file = $target_dir . $image;

        // cek dan upload
        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
            // berhasil upload
        } else {
            echo "<script>alert('Upload gambar gagal');</script>";
            $image = "";
        }
    }

    // Simpan ke database
    $sql = "INSERT INTO carousel_slides (title, description, image, status, sort_order) 
            VALUES ('$title', '$description', '$image', '$status', '$sort_order')";
    $query = mysqli_query($conn, $sql);

    if($query){
        echo "<script>alert('Slide berhasil ditambahkan'); window.location='carousel.php';</script>";
    } else {
        echo "<script>alert('Gagal menambahkan slide');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Slide Carousel</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php include "navbar.php"; ?>

<div class="container mt-4">
  <nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item"><a href="carousel.php">Kelola Carousel</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tambah Slide</li>
    </ol>
  </nav>

  <h3>Tambah Slide Baru</h3>
  <form action="" method="post" enctype="multipart/form-data" class="mt-3">
    <div class="mb-3">
      <label for="title" class="form-label">Judul</label>
      <input type="text" name="title" id="title" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Deskripsi</label>
      <textarea name="description" id="description" class="form-control"></textarea>
    </div>

    <div class="mb-3">
      <label for="image" class="form-label">Gambar</label>
      <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
    </div>

    <div class="mb-3">
      <label for="status" class="form-label">Status</label>
      <select name="status" id="status" class="form-select">
        <option value="active">Aktif</option>
        <option value="inactive">Nonaktif</option>
      </select>
    </div>

    <button type="submit" name="simpan" class="btn btn-success"><i class="fas fa-save"></i> Simpan</button>
    <a href="carousel.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
