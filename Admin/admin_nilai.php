<?php
include "../koneksi.php";
include "session.php";

// inisialisasi variabel agar tidak ada warning saat halaman pertama kali dibuka
$nama = $jenjang = $mapel = $tahun = '';
$kelas = 1;
$semester = 1;
$nilai = '';
$success = $error = '';

// proses ketika form disubmit (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama'] ?? '');
    $jenjang  = $_POST['jenjang'] ?? '';
    $kelas    = isset($_POST['kelas']) ? intval($_POST['kelas']) : 0;
    $mapel    = $_POST['mapel'] ?? '';
    $tahun    = $_POST['tahun'] ?? '';
    $semester = isset($_POST['semester']) ? intval($_POST['semester']) : 0;
    $nilai    = isset($_POST['nilai']) ? floatval($_POST['nilai']) : null;

    $errors = [];
    $allowedJenjang = ['SD', 'SMP', 'SMA'];
    if ($nama === '') $errors[] = 'Nama siswa harus diisi.';
    if (!in_array($jenjang, $allowedJenjang)) $errors[] = 'Pilih jenjang yang valid.';
    if ($kelas < 1 || $kelas > 12) $errors[] = 'Kelas tidak valid.';
    if ($mapel === '') $errors[] = 'Mata pelajaran harus dipilih.';
    if ($tahun === '') $errors[] = 'Tahun ajaran harus dipilih.';
    if (!in_array($semester, [1, 2])) $errors[] = 'Semester harus 1 atau 2.';
    if ($nilai === null || $nilai < 0 || $nilai > 100) $errors[] = 'Nilai harus antara 0 - 100.';

    if (empty($errors)) {
        $sql = "INSERT INTO nilai (nama_siswa, jenjang, kelas, mata_pelajaran, tahun_ajaran, semester, nilai)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssissid", $nama, $jenjang, $kelas, $mapel, $tahun, $semester, $nilai);
            if (mysqli_stmt_execute($stmt)) {
                $success = "Data nilai berhasil disimpan.";
                $nama = $jenjang = $mapel = $tahun = '';
                $kelas = 1;
                $semester = 1;
                $nilai = '';
            } else {
                $error = "Gagal menyimpan data: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            $error = "Query gagal dipersiapkan: " . mysqli_error($conn);
        }
    } else {
        $error = implode('<br>', $errors);
    }
}
?>
<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Input Nilai</title>
    <link rel="stylesheet" href="../bootstrap-5.2.3-dist/bootstrap-5.2.3-dist/css/bootstrap.min.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .summary-box {
            border-radius: 20px;
            color: #fff;
            padding: 25px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.2s, box-shadow 0.2s;
            cursor: pointer;
        }

        .summary-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .summary-carousel {
            background: linear-gradient(135deg, #6b0a3a, #a3145d);
        }

        .summary-produk {
            background: linear-gradient(135deg, #0a516b, #117f9b);
        }

        .summary-nilai {
            background: linear-gradient(135deg, #d39e00, #ffc107);
        }

        .summary-box i {
            opacity: 0.7;
        }

        .summary-box h3 {
            font-size: 1.8rem;
            margin-bottom: 5px;
        }

        .summary-box p {
            margin: 0;
        }

        .summary-box .btn {
            border-radius: 30px;
            font-size: 0.9rem;
            padding: 6px 16px;
            margin-top: 10px;
        }

        .breadcrumb {
            background: transparent;
            padding: 0;
        }

        h2 {
            font-weight: 600;
        }


        .btn-simpan {
            background: #ffd84d;
            border: 2px solid #000;
            font-weight: bold;
            border-radius: 25px;
            padding: 10px 30px
        }

        .form-label {
            font-weight: 600
        }
    </style>
</head>

<body>
    <?php include "navbar.php"; ?>

    <div class="container mt-5">
        <h3 class="text-center mb-4">Input Nilai Siswa</h3>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" novalidate>
            <div class="mb-3">
                <label class="form-label">Nama Siswa</label>
                <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($nama) ?>" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenjang</label>
                    <select name="jenjang" id="jenjang" class="form-select" required>
                        <option value="">-- Pilih Jenjang --</option>
                        <option value="SD" <?= $jenjang === 'SD' ? 'selected' : '' ?>>SD</option>
                        <option value="SMP" <?= $jenjang === 'SMP' ? 'selected' : '' ?>>SMP</option>
                        <option value="SMA" <?= $jenjang === 'SMA' ? 'selected' : '' ?>>SMA</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="kelas" id="kelas" class="form-select" required>
                        <!-- akan diisi lewat javascript -->
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Mata Pelajaran</label>
                <select name="mapel" class="form-select" required>
                    <option value="">-- Pilih Mapel --</option>
                    <option <?= $mapel === 'PANCASILA' ? 'selected' : '' ?>>PANCASILA</option>
                    <option <?= $mapel === 'MATEMATIKA' ? 'selected' : '' ?>>MATEMATIKA</option>
                    <option <?= $mapel === 'PENDIDIKAN AGAMA ISLAM' ? 'selected' : '' ?>>PENDIDIKAN AGAMA ISLAM</option>
                    <option <?= $mapel === 'BAHASA INDONESIA' ? 'selected' : '' ?>>BAHASA INDONESIA</option>
                    <option <?= $mapel === 'ILMU PENGETAHUAN ALAM' ? 'selected' : '' ?>>ILMU PENGETAHUAN ALAM</option>
                    <option <?= $mapel === 'ILMU PENGETAHUAN SOSIAL' ? 'selected' : '' ?>>ILMU PENGETAHUAN SOSIAL</option>
                    <option <?= $mapel === 'BAHASA INGGRIS' ? 'selected' : '' ?>>BAHASA INGGRIS</option>
                </select>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tahun Ajaran</label>
                    <select name="tahun" class="form-select" required>
                        <option <?= $tahun === '2024/2025' ? 'selected' : '' ?>>2024/2025</option>
                        <option <?= $tahun === '2025/2026' ? 'selected' : '' ?>>2025/2026</option>
                        <option <?= $tahun === '2026/2027' ? 'selected' : '' ?>>2026/2027</option>
                        <option <?= $tahun === '2027/2028' ? 'selected' : '' ?>>2027/2028</option>
                        <option <?= $tahun === '2028/2029' ? 'selected' : '' ?>>2028/2029</option>
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label class="form-label">Semester</label>
                    <select name="semester" class="form-select" required>
                        <option value="1" <?= $semester == 1 ? 'selected' : '' ?>>1</option>
                        <option value="2" <?= $semester == 2 ? 'selected' : '' ?>>2</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Nilai</label>
                <input type="number" name="nilai" class="form-control" step="0.01" min="0" max="100" value="<?= htmlspecialchars($nilai) ?>" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn-simpan">SIMPAN</button>
            </div>
        </form>
    </div>

    <script>
        const jenjangSelect = document.getElementById('jenjang');
        const kelasSelect = document.getElementById('kelas');

        const opsiKelas = {
            'SD': [1, 2, 3, 4, 5, 6],
            'SMP': [7, 8, 9],
            'SMA': [10, 11, 12]
        };

        function updateKelas() {
            const j = jenjangSelect.value;
            kelasSelect.innerHTML = '';
            if (opsiKelas[j]) {
                opsiKelas[j].forEach(k => {
                    const opt = document.createElement('option');
                    opt.value = k;
                    opt.textContent = k;
                    kelasSelect.appendChild(opt);
                });
            }
        }

        jenjangSelect.addEventListener('change', updateKelas);
        updateKelas(); // jalankan pertama kali
    </script>

    <script src="../bootstrap-5.2.3-dist/bootstrap-5.2.3-dist/js/bootstrap.bundle.min.js"></script>
    <script src="../fontawesome/js/all.min.js"></script>

</body>

</html>