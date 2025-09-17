<?php
include "session.php";
include "../koneksi.php";

// Pastikan ada parameter id
if (!isset($_GET['id']) || $_GET['id'] == '') {
    header("Location: carousel.php");
    exit;
}

$id = (int) $_GET['id'];

// Ambil data slide berdasarkan id
$query = mysqli_query($conn, "SELECT * FROM carousel_slides WHERE id=$id");
$data = mysqli_fetch_assoc($query);

if (!$data) {
    echo "<script>alert('Slide tidak ditemukan'); window.location='carousel.php';</script>";
    exit;
}

// Jika ada gambar, hapus file fisik dari folder
if ($data['image'] != "" && file_exists("../uploads/" . $data['image'])) {
    unlink("../uploads/" . $data['image']);
}

// Hapus data dari database
$delete = mysqli_query($conn, "DELETE FROM carousel_slides WHERE id=$id");

if ($delete) {
    echo "<script>alert('Slide berhasil dihapus'); window.location='carousel.php';</script>";
} else {
    echo "<script>alert('Gagal menghapus slide'); window.location='carousel.php';</script>";
}
