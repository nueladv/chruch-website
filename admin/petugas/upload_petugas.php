<?php
$direktori_petugas = '../../assets/images/petugas/';
$file_petugas = null;

// Pastikan direktori ada
if (!file_exists($direktori_petugas)) {
    mkdir($direktori_petugas, 0777, true);
}

// Fungsi untuk menampilkan gambar terbaru
$files = glob($direktori_petugas . '*');
if ($files) {
    usort($files, function($a, $b) {
        return filemtime($b) - filemtime($a);
    });
    $file_petugas = basename($files[0]);
}

// Fungsi untuk upload gambar baru
if (isset($_POST['upload'])) {
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $target_file = $direktori_petugas . basename($_FILES["gambar"]["name"]);
        
        // Cek apakah file gambar valid (misalnya, hanya gambar yang bisa diupload)
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        if (in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
            if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
                echo "<div class='alert alert-success'>File berhasil diupload.</div>";
            } else {
                echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengupload file.</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>Hanya file gambar yang dapat diupload (jpg, jpeg, png, gif).</div>";
        }
    }
}

// Fungsi untuk memperbarui gambar
if (isset($_POST['update'])) {
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $old_image = $_POST['old_image'];
        $target_file = $direktori_petugas . basename($_FILES["gambar"]["name"]);
        
        // Hapus gambar lama jika ada
        if (file_exists($direktori_petugas . $old_image)) {
            unlink($direktori_petugas . $old_image);
        }

        // Upload gambar baru
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            echo "<div class='alert alert-success'>File berhasil diperbarui.</div>";
        } else {
            echo "<div class='alert alert-danger'>Terjadi kesalahan saat mengganti file.</div>";
        }
    }
}

// Fungsi untuk menghapus gambar
if (isset($_POST['delete'])) {
    $file_to_delete = $_POST['file_to_delete'];
    if (file_exists($direktori_petugas . $file_to_delete)) {
        unlink($direktori_petugas . $file_to_delete);
        echo "<div class='alert alert-success'>File berhasil dihapus.</div>";
    } else {
        echo "<div class='alert alert-danger'>File tidak ditemukan.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Gambar Petugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Upload Gambar Petugas</h1>
        
        <!-- Back Button -->
        <a href="../../../admin/upload.php" class="btn btn-secondary mb-3">Kembali ke Halaman Admin</a>

        <!-- Form Upload -->
        <form action="upload_petugas.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="gambar">Pilih gambar untuk diupload:</label>
                <input type="file" name="gambar" id="gambar" class="form-control" required>
            </div>
            <button type="submit" name="upload" class="btn btn-primary">Upload Gambar</button>
        </form>

        <hr>

        <!-- Form Update -->
        <?php if ($file_petugas): ?>
            <h2>Perbarui Gambar Petugas</h2>
            <form action="upload_petugas.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="old_image" value="<?php echo $file_petugas; ?>">
                <div class="form-group">
                    <label for="gambar">Pilih gambar baru untuk mengganti:</label>
                    <input type="file" name="gambar" id="gambar" class="form-control" required>
                </div>
                <button type="submit" name="update" class="btn btn-warning">Perbarui Gambar</button>
            </form>
        <?php else: ?>
            <p>Tidak ada gambar petugas yang diupload.</p>
        <?php endif; ?>

        <hr>

        <!-- Form Delete -->
        <?php if ($file_petugas): ?>
            <h2>Hapus Gambar Petugas</h2>
            <form action="upload_petugas.php" method="post">
                <input type="hidden" name="file_to_delete" value="<?php echo $file_petugas; ?>">
                <button type="submit" name="delete" class="btn btn-danger">Hapus Gambar</button>
            </form>
        <?php endif; ?>

        <hr>

        <!-- Menampilkan Gambar yang Ada -->
        <h2>Gambar Petugas Mingguan</h2>
        <?php if ($file_petugas): ?>
            <img src="<?php echo $direktori_petugas . $file_petugas; ?>" alt="Gambar Petugas Mingguan" class="img-fluid">
        <?php else: ?>
            <p>Tidak ada gambar petugas yang tersedia.</p>
        <?php endif; ?>
    </div>
</body>
</html>
