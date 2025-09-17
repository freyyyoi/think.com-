<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "think_indonesia";

$koneksi = new mysqli($host, $user, $pass, $db);
$conn    = $koneksi; // buat alias agar $conn juga bisa dipakai

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>
