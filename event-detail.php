<?php
// Memulai sesi dan menghubungkan ke database
session_start();
include('db.php');  // Pastikan path relatif sesuai dengan lokasi db.php

// Validasi ID yang diterima melalui URL (parameter 'id')
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid event ID.");
}

// Mengambil ID event dari URL dan menghindari SQL injection
$event_id = $_GET['id'];

// Menggunakan prepared statement untuk menghindari SQL injection
$stmt = $conn->prepare("SELECT * FROM informasi WHERE id = ?");
$stmt->bind_param("i", $event_id);  // "i" untuk integer
$stmt->execute();
$result = $stmt->get_result();

// Memeriksa apakah event dengan ID tersebut ada
if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
} else {
    die("Event not found.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Event - Gereja St. Petrus Sambiroto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container mt-5">
        <!-- Tampilkan Gambar Event -->
        <?php if (!empty($event['gambar'])): ?>
            <div class="text-center mb-4">
                <img src="assets/images/<?php echo $event['gambar']; ?>" class="img-fluid" alt="Event Image">
            </div>
        <?php else: ?>
            <p class="text-center">Tidak ada gambar untuk event ini.</p>
        <?php endif; ?>

        <!-- Keterangan Event -->
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h3>Detail Event</h3>
                <p><strong>Judul:</strong> <?php echo $event['judul']; ?></p>
                <p><strong>Deskripsi:</strong> <?php echo $event['deskripsi']; ?></p>
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Kembali ke Halaman Utama</a>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; <?php echo date("Y"); ?> Emmanuel Vito | Made with ❤️ by Komsos Sambiroto</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
