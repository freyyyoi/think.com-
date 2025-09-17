<?php
include "../koneksi.php";
include "session.php";

$id_pertemuan = $_GET['id'];

// Ambil detail tanggal pertemuan
$pertemuan = $koneksi->query("SELECT tanggal FROM pertemuan WHERE id_pertemuan='$id_pertemuan'")->fetch_assoc();
$tanggal = $pertemuan ? $pertemuan['tanggal'] : date("Y-m-d");

// Ambil data siswa & status absensinya
$query = "
    SELECT s.id_siswa, s.nama_siswa, 
           IFNULL(a.status, '') AS status
    FROM siswa s
    LEFT JOIN absensi a 
        ON s.id_siswa = a.id_siswa 
       AND a.id_pertemuan = '$id_pertemuan'
";
$result = $koneksi->query($query);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    foreach ($_POST['status'] as $id_siswa => $status) {
        // Hapus absensi lama
        $koneksi->query("DELETE FROM absensi WHERE id_siswa='$id_siswa' AND id_pertemuan='$id_pertemuan'");
        // Masukkan absensi baru
        if ($status != "") {
            $koneksi->query("INSERT INTO absensi (id_siswa, id_pertemuan, status) VALUES ('$id_siswa','$id_pertemuan','$status')");
        }
    }
    header("Location: absensi.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Pertemuan</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f8f9fa; margin:0; }
        .container { width:80%; margin:20px auto; background:#fff; padding:20px; border-radius:8px; }
        h2 { margin:0 0 20px 0; }

        .form-header { display:flex; gap:10px; margin-bottom:20px; }
        select { padding:5px; border:1px solid #ddd; border-radius:4px; }

        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background: #f1f1f1; }

        input[type=radio] { accent-color: orange; }

        .actions { margin-top:20px; text-align:right; }
        .btn { padding:8px 16px; border:none; border-radius:4px; cursor:pointer; }
        .btn-cancel { background:#333; color:white; margin-right:10px; }
        .btn-save { background:orange; color:white; }
    </style>
</head>
<body>
<div class="container">
    <h2>Edit Pertemuan</h2>

    <!-- Dropdown tanggal (readonly, hanya tampil info) -->
    <div class="form-header">
        <?php
        $tgl = date("d", strtotime($tanggal));
        $bln = date("m", strtotime($tanggal));
        $thn = date("Y", strtotime($tanggal));

        $namaBulan = [
            "01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April",
            "05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus",
            "09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember"
        ];
        ?>
        <select disabled>
            <option><?= $tgl ?></option>
        </select>
        <select disabled>
            <option><?= $namaBulan[$bln] ?></option>
        </select>
        <select disabled>
            <option><?= $thn ?></option>
        </select>
    </div>

    <form method="POST">
        <table>
            <tr>
                <th>No</th>
                <th>Nama Siswa</th>
                <th>Masuk</th>
                <th>Sakit</th>
                <th>Izin</th>
                <th>Alpa</th>
            </tr>
            <?php 
            $no=1;
            while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td style="text-align:left;"><?= $row['nama_siswa'] ?></td>
                <td><input type="radio" name="status[<?= $row['id_siswa'] ?>]" value="Masuk" <?= ($row['status']=='Masuk'?'checked':'') ?>></td>
                <td><input type="radio" name="status[<?= $row['id_siswa'] ?>]" value="Sakit" <?= ($row['status']=='Sakit'?'checked':'') ?>></td>
                <td><input type="radio" name="status[<?= $row['id_siswa'] ?>]" value="Izin"  <?= ($row['status']=='Izin'?'checked':'') ?>></td>
                <td><input type="radio" name="status[<?= $row['id_siswa'] ?>]" value="Alpa"  <?= ($row['status']=='Alpa'?'checked':'') ?>></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <div class="actions">
            <a href="absensi.php" class="btn btn-cancel">Batal</a>
            <button type="submit" class="btn btn-save">Simpan</button>
        </div>
    </form>
</div>
</body>
</html>