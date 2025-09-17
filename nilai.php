<?php
include "koneksi.php";

$filter = "";
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['jenjang'])) {
    $jenjang = mysqli_real_escape_string($conn, $_GET['jenjang']);
    $kelas   = intval($_GET['kelas']);
    $tahun   = mysqli_real_escape_string($conn, $_GET['tahun']);
    $semester = intval($_GET['semester']);
    $mapel   = mysqli_real_escape_string($conn, $_GET['mapel']);

    $filter = "WHERE jenjang='$jenjang' AND kelas=$kelas 
               AND tahun_ajaran='$tahun' AND semester=$semester 
               AND mata_pelajaran='$mapel'";
}

$result = mysqli_query($conn, "SELECT * FROM nilai $filter");
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

$avgResult = mysqli_query($conn, "SELECT AVG(nilai) AS rata FROM nilai $filter");
$avgRow = mysqli_fetch_assoc($avgResult);
$rataKelas = $avgRow['rata'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buku Nilai</title>
    <link rel="stylesheet" href="bootstrap-5.2.3-dist/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <style>
        body {
            background: #fdfdfd;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
        }

        .judul-section {
            text-align: center;
            margin-top: 40px
        }

        .judul-section h2 {
            background: #ffd84d;
            display: inline-block;
            padding: 10px 30px;
            border-radius: 30px;
            font-weight: bold
        }

        .filter-box {
            background: #e2e2e2;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px
        }

        .btn-go {
            background: #ffd84d;
            border: 2px solid #000;
            border-radius: 20px;
            padding: 5px 25px;
            font-weight: bold
        }

        .nilai-table {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse
        }

        .nilai-table thead th {
            background: #d9d9d9;
            padding: 12px;
            text-align: center
        }

        .nilai-table tbody td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd
        }

        .rata-kelas {
            background: #ffe56f;
            font-weight: bold
        }

        .nilai-table th:nth-child(1),
        .nilai-table td:nth-child(1) {
            border-right: 2px solid #000
        }
    </style>
</head>

<body>
  <?php
    include "navbar.php";
  ?>
    <div class="container">
        <div class="judul-section">
            <h2>Buku Nilai</h2>
        </div>

        <form class="filter-box row g-3 align-items-center justify-content-center" method="GET">
            <div class="col-md-2">
                <label>Jenjang</label>
                <select class="form-select" name="jenjang" id="jenjang" required>
                    <option value="SD" <?= (($_GET['jenjang'] ?? '') == 'SD') ? 'selected' : '' ?>>SD</option>
                    <option value="SMP" <?= (($_GET['jenjang'] ?? '') == 'SMP') ? 'selected' : '' ?>>SMP</option>
                    <option value="SMA" <?= (($_GET['jenjang'] ?? '') == 'SMA') ? 'selected' : '' ?>>SMA</option>
                </select>
            </div>

            <div class="col-md-2">
                <label>Kelas</label>
                <select class="form-select" name="kelas" id="kelas" required>
                    <!-- kelas akan diisi oleh JavaScript -->
                </select>
            </div>

            <div class="col-md-2">
                <label>Tahun Ajaran</label>
                <select class="form-select" name="tahun" required>
                    <?php
                    $tahunList = ['2024/2025', '2025/2026', '2026/2027', '2027/2028', '2028/2029'];
                    foreach ($tahunList as $t): ?>
                        <option value="<?= $t ?>" <?= (($_GET['tahun'] ?? '') == $t) ? 'selected' : '' ?>>
                            <?= $t ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-1">
                <label>Semester</label>
                <select class="form-select" name="semester" required>
                    <option value="1" <?= (($_GET['semester'] ?? '') == '1') ? 'selected' : '' ?>>1</option>
                    <option value="2" <?= (($_GET['semester'] ?? '') == '2') ? 'selected' : '' ?>>2</option>
                </select>
            </div>

            <div class="col-md-2">
                <label>Mapel</label>
                <select class="form-select" name="mapel" required>
                    <?php
                    $mapelList = ['PANCASILA', 'MATEMATIKA', 'PENDIDIKAN AGAMA ISLAM', 'BAHASA INDONESIA', 'ILMU PENGETAHUAN ALAM', 'ILMU PENGETAHUAN SOSIAL', 'BAHASA INGGRIS'];
                    foreach ($mapelList as $m): ?>
                        <option value="<?= $m ?>" <?= (($_GET['mapel'] ?? '') == $m) ? 'selected' : '' ?>>
                            <?= $m ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-md-1 text-center">
                <label class="d-block">&nbsp;</label>
                <button type="submit" class="btn-go">GO</button>
            </div>
        </form>

        <div class="table-container">
            <table class="nilai-table mt-4">
                <thead>
                    <tr>
                        <th width="50%">NAMA</th>
                        <th>Rata-rata nilai siswa</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="rata-kelas">
                        <td>Rata-rata nilai kelas</td>
                        <td><?= number_format($rataKelas, 2) ?></td>
                    </tr>
                    <?php foreach ($data as $row): ?>
                        <tr>
                            <td><?= $row['nama_siswa']; ?></td>
                            <td><?= $row['nilai']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        const kelasSelect = document.getElementById('kelas');
        const jenjangSelect = document.getElementById('jenjang');
        const selectedKelas = "<?= $_GET['kelas'] ?? '' ?>";

        function updateKelas() {
            const jenjang = jenjangSelect.value;
            let start = 1,
                end = 6;
            if (jenjang === 'SD') {
                start = 1;
                end = 6;
            } else if (jenjang === 'SMP') {
                start = 7;
                end = 9;
            } else if (jenjang === 'SMA') {
                start = 10;
                end = 12;
            }

            kelasSelect.innerHTML = "";
            for (let i = start; i <= end; i++) {
                const opt = document.createElement('option');
                opt.value = i;
                opt.textContent = i;
                if (i == selectedKelas) opt.selected = true;
                kelasSelect.appendChild(opt);
            }
        }

        jenjangSelect.addEventListener('change', updateKelas);
        updateKelas(); // isi awal saat load
    </script>
    <br>
    <?php
    include "footer.php";
    ?>
    <script src="bootstrap-5.2.3-dist/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>