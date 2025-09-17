<?php
include "session.php";
include "../koneksi.php";

// Pastikan ada parameter id
if(!isset($_GET['id']) || $_GET['id'] == ''){
    header("Location: carousel.php");
    exit;
}

$id = (int) $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM carousel_slides WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if(!$data){
    echo "<script>alert('Slide tidak ditemukan'); window.location='carousel.php';</script>";
    exit;
}

// Proses form update
if(isset($_POST['update'])){
    $title       = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $status      = $_POST['status'];
    $sort_order  = (int) $_POST['sort_order'];

    // Proses upload gambar baru
    $image = $data['image'];
    if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != ""){
        $target_dir = "../uploads/";
        $new_image = time() . "_" . basename($_FILES['image']['name']);
        $target_file = $target_dir . $new_image;

        if(move_uploaded_file($_FILES['image']['tmp_name'], $target_file)){
            // hapus file lama jika ada
            if($image != "" && file_exists("../uploads/".$image)){
                unlink("../uploads/".$image);
            }
            $image = $new_image;
        } else {
            echo "<script>alert('Upload gambar baru gagal');</script>";
        }
    }

    // Update ke database
    $sql = "UPDATE carousel_slides 
            SET title='$title', description='$description', image='$image', status='$status', sort_order='$sort_order'
            WHERE id=$id";
    $update = mysqli_query($conn, $sql);

    if($update){
        echo "<script>alert('Slide berhasil diperbarui'); window.location='carousel.php';</script>";
    } else {
        echo "<script>alert('Gagal memperbarui slide');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Slide Carousel</title>
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
      <li class="breadcrumb-item active" aria-current="page">Edit Slide</li>
    </ol>
  </nav>

  <h3>Edit Slide</h3>
  <form action="" method="post" enctype="multipart/form-data" class="mt-3">
    <div class="mb-3">
      <label for="title" class="form-label">Judul</label>
      <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($data['title']); ?>" required>
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Deskripsi</label>
      <textarea name="description" id="description" class="form-control"><?= htmlspecialchars($data['description']); ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Gambar Saat Ini</label><br>
      <?php if($data['image']){ ?>
        <img src="../uploads/<?= $data['image']; ?>" alt="" width="200"><br><br>
      <?php } else { ?>
        <span class="text-muted">Tidak ada gambar</span><br><br>
      <?php } ?>
      <label for="image" class="form-label">Ganti Gambar (Opsional)</label>
      <input type="file" name="image" id="image" class="form-control" accept="image/*">
    </div>

    <div class="mb-3">
      <label for="status" class="form-label">Status</label>
      <select name="status" id="status" class="form-select">
        <option value="active" <?= ($data['status']=='active' ? 'selected' : ''); ?>>Aktif</option>
        <option value="inactive" <?= ($data['status']=='inactive' ? 'selected' : ''); ?>>Nonaktif</option>
      </select>
    </div>

    <button type="submit" name="update" class="btn btn-primary"><i class="fas fa-save"></i> Update</button>
    <a href="carousel.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
  </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../fontawesome/js/all.min.js"></script>
</body>
</html>
