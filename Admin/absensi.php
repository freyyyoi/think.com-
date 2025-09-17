<?php
include "../koneksi.php";
include "session.php";

// Ambil bulan & tahun dari query string (default bulan sekarang)
$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date("m");
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date("Y");

// Nama bulan Indonesia
$namaBulan = [
    "01"=>"Januari","02"=>"Februari","03"=>"Maret","04"=>"April",
    "05"=>"Mei","06"=>"Juni","07"=>"Juli","08"=>"Agustus",
    "09"=>"September","10"=>"Oktober","11"=>"November","12"=>"Desember"
];

// Ambil semua tanggal bulan ini
$jumlahHari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Absensi Harian</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f8f9fa; margin: 0; }
        .container { width: 80%; margin: 20px auto; background: #fff; padding: 20px; border-radius: 8px; }
        h2 { margin: 0; padding-bottom: 10px; text-align: center; }

        /* Tabs */
        .tabs { display: flex; border-bottom: 2px solid #ddd; margin-bottom: 10px; }
        .tab { padding: 10px 20px; cursor: pointer; }
        .tab.active { border-bottom: 3px solid orange; font-weight: bold; }

        /* Dropdown */
        select { padding: 6px; border-radius: 4px; border: 1px solid #ddd; margin: 10px 0; }

        /* Table */
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: center; }
        th { background: #f1f1f1; }
        tr:nth-child(even) { background: #f9f9f9; }
        .libur { background: #fef0f0; color: red; font-weight: bold; text-align:center; }
        a.edit { color: orange; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
<div class="container">
    <h2>Absensi Kelas XII</h2>

    <!-- Tabs -->
    <div class="tabs">
        <div class="tab active">HARIAN</div>
        <div class="tab">BULANAN</div>
        <div class="tab">TAHUNAN</div>
    </div>

    <!-- Dropdown Bulan Tahun -->
    <form method="GET" style="text-align:left;">
        <select name="bulan">
            <?php foreach($namaBulan as $key=>$val): ?>
                <option value="<?= $key ?>" <?= ($bulan==$key?'selected':'') ?>><?= $val ?></option>
            <?php endforeach; ?>
        </select>
        <select name="tahun">
            <?php for($i=2023;$i<=2030;$i++): ?>
                <option value="<?= $i ?>" <?= ($tahun==$i?'selected':'') ?>><?= $i ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit">Tampilkan</button>
    </form>

    <!-- Table -->
    <table>
        <tr>
            <th>Tanggal</th>
            <th>M</th>
            <th>S</th>
            <th>I</th>
            <th>A</th>
            <th>Opsi</th>
        </tr>
        <?php 
        for($tgl=1; $tgl<=$jumlahHari; $tgl++):
            $tanggal = sprintf("%04d-%02d-%02d",$tahun,$bulan,$tgl);
            $hari = date("D", strtotime($tanggal));

            // ambil data absensi per hari
            $q = "
                SELECT 
                    SUM(CASE WHEN status='Masuk' THEN 1 ELSE 0 END) AS M,
                    SUM(CASE WHEN status='Sakit' THEN 1 ELSE 0 END) AS S,
                    SUM(CASE WHEN status='Izin'  THEN 1 ELSE 0 END) AS I,
                    SUM(CASE WHEN status='Alpa'  THEN 1 ELSE 0 END) AS A
                FROM absensi a
                JOIN pertemuan p ON a.id_pertemuan=p.id_pertemuan
                WHERE p.tanggal='$tanggal'
            ";
            if (!isset($koneksi)) {
    die("Koneksi belum tersedia, pastikan koneksi.php sudah di-include.");
}

            $res = $koneksi->query($q);
            $data = $res->fetch_assoc();

            $M = $data['M'] ?? 0;
            $S = $data['S'] ?? 0;
            $I = $data['I'] ?? 0;
            $A = $data['A'] ?? 0;

            // cari id_pertemuan
            $idPertemuan = $koneksi->query("SELECT id_pertemuan FROM pertemuan WHERE tanggal='$tanggal'")->fetch_assoc()['id_pertemuan'] ?? null;

            if ($hari == "Sun") {
                echo "<tr><td style='color:red;'>".sprintf("%02d",$tgl)." Min</td>
                      <td colspan='5' class='libur'>Libur Akhir Pekan</td></tr>";
            } else {
                echo "<tr>
                        <td>".sprintf("%02d",$tgl)." $hari</td>
                        <td>$M</td>
                        <td>$S</td>
                        <td>$I</td>
                        <td>$A</td>
                        <td>";
                if ($idPertemuan) {
                    echo "<a class='edit' href='edit_absensi.php?id=$idPertemuan'>Edit</a>";
                } else {
                    echo "-";
                }
                echo "</td></tr>";
            }
        endfor;
        ?>
    </table>
</div>
</body>
</html>