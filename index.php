<?php
session_start();
include('db.php');  // Pastikan path relatif sesuai dengan lokasi db.php

// Get All Information (Event Information)
$sql = "SELECT * FROM informasi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width:device-width, initial-scale=1.0">
    <title>Gereja St. Petrus Sambiroto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <header class="py-2">
        <div class="container d-flex justify-content-between align-items-center">
            <img src="assets/logo/logo-gereja.png" alt="Logo Gereja" class="img-fluid" style="max-height: 80px;">
            <img src="assets/logo/logo-komsos.png" alt="Logo Komsos" class="img-fluid" style="max-height: 130px;">
        </div>
    </header>

    <div class="container mt-5">
        <div class="row mb-4 text-center">
            <div class="col-md-12">
                <h1 class="display-4">Gereja St. Petrus Sambiroto</h1>
                <p class="lead">Paroki Sambiroto</p>
            </div>
        </div>

        <div class="row mb-4 justify-content-center">
            <div class="col-md-6">
                <p class="lead">
                    Gereja St. Petrus Sambiroto adalah tempat ibadah yang terletak di kawasan Sambiroto, dengan berbagai kegiatan yang melibatkan komunitas setempat. Gereja ini memiliki sejarah panjang yang penuh dengan kegiatan rohani dan sosial yang bermanfaat bagi umat di sekitarnya. Kami mengundang Anda untuk bergabung dalam perayaan dan berbagai acara yang diadakan sepanjang tahun. Mari bersama-sama memperkuat iman kita melalui kebersamaan dan pelayanan.
                </p>
            </div>
        </div>

        <div class="row mb-4 justify-content-center">
            <div class="col-md-3">
                <a href="https://drive.google.com/drive/folders/1jRgoGIXeCDNrZYJnFX9uOF4OIztk2tih?usp=sharing" class="btn btn-primary btn-lg w-100" target="_blank">Dokumentasi Gereja</a>
            </div>
            <div class="col-md-3">
                <?php
                $direktori_petugas = 'assets/images/petugas/';
                $file_petugas = null;

                // Baca file gambar dari direktori
                $files = glob($direktori_petugas . '*');
                if ($files) {
                    // Urutkan file berdasarkan tanggal modifikasi terbaru
                    usort($files, function($a, $b) {
                        return filemtime($b) - filemtime($a);
                    });
                    $file_petugas = basename($files[0]);
                }
                if ($file_petugas): ?>
                    <a href="<?php echo '/assets/images/petugas/' . $file_petugas; ?>" class="btn btn-success btn-lg w-100">Petugas Mingguan</a>
                <?php else: ?>
                    <button class="btn btn-secondary btn-lg w-100" disabled>Petugas Mingguan</button>
                    <p class="text-muted">Tidak ada gambar petugas mingguan.</p>
                <?php endif; ?>
            </div>
            <div class="col-md-3">
                <a href="https://example.com/elibrary" class="btn btn-warning btn-lg w-100" target="_blank">E-Library</a>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <h2>Event Paroki</h2>
                <p class="lead">Informasi mengenai event yang akan datang</p>
            </div>
        </div>

        <div id="eventCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                $first = true;  // Variabel untuk menandai item pertama
                while ($row = $result->fetch_assoc()) {
                    $activeClass = $first ? 'active' : '';  // Menambahkan class "active" hanya pada item pertama
                    $first = false;
                ?>
                    <div class="carousel-item <?php echo $activeClass; ?>">
                        <img src="assets/images/<?php echo $row['gambar']; ?>" class="d-block w-100" alt="Event Image">
                        <div class="carousel-caption d-none d-md-block">
                            <h5><?php echo $row['judul']; ?></h5>
                            <p><?php echo $row['deskripsi']; ?></p>
                            <a href="event-detail.php?id=<?php echo $row['id']; ?>" class="btn btn-light">Klik Disini</a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#eventCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#eventCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; <?php echo date("Y"); ?> Emmanuel Vito | Made with ❤️ by Komsos Sambiroto</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>