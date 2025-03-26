<?php
session_start();
include('../db.php');  // Pastikan koneksi ke database berhasil

// Pastikan hanya admin yang bisa mengakses halaman ini
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit();
}

// Logout - Hapus session dan arahkan kembali ke halaman login
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: login.php');
    exit();
}

// Handle Add Event (Informasi Event Paroki)
if (isset($_POST['add_event'])) {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];
    $target_dir = "../assets/images/";
    $target_file = $target_dir . basename($gambar);
    move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);

    $sql = "INSERT INTO informasi (judul, deskripsi, gambar) VALUES ('$judul', '$deskripsi', '$gambar')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Informasi berhasil ditambahkan!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Edit Event
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $sql = "SELECT * FROM informasi WHERE id = $id";
    $result = $conn->query($sql);
    $event = $result->fetch_assoc();
}

// Handle Update Event
if (isset($_POST['update_event'])) {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];
    $gambar = $_FILES['gambar']['name'];

    if ($gambar) {
        $target_dir = "../assets/images/";
        $target_file = $target_dir . basename($gambar);
        move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file);
    } else {
        $gambar = $_POST['old_image'];  // Gunakan gambar lama jika tidak diubah
    }

    $sql = "UPDATE informasi SET judul = '$judul', deskripsi = '$deskripsi', gambar = '$gambar' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Informasi berhasil diperbarui!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Handle Delete Event
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM informasi WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Informasi berhasil dihapus!');</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}

// Get All Information (Event Paroki)
$sql = "SELECT * FROM informasi";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../css/style3.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Dashboard Admin</h1>
            <div class="header-buttons">
                <a href="/admin/petugas/upload_petugas.php" class="btn-petugas">Petugas</a>
                <a href="upload.php?logout=true" class="logout-button">Logout</a>
            </div>
        </header>

        <!-- Form untuk Menambah Event -->
        <section class="add-info">
            <h2>Tambah Informasi Event Paroki</h2>
            <form method="POST" enctype="multipart/form-data">
                <label for="judul">Judul:</label>
                <input type="text" name="judul" required><br><br>

                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" required></textarea><br><br>

                <label for="gambar">Gambar:</label>
                <input type="file" name="gambar" required><br><br>

                <button type="submit" name="add_event" class="btn-submit">Tambah Event</button>
            </form>
        </section>

        <!-- Form untuk Mengedit Event -->
        <?php if (isset($event)): ?>
        <section class="edit-info">
            <h2>Edit Informasi Event Paroki</h2>
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?php echo $event['id']; ?>">
                <input type="hidden" name="old_image" value="<?php echo $event['gambar']; ?>">

                <label for="judul">Judul:</label>
                <input type="text" name="judul" value="<?php echo $event['judul']; ?>" required><br><br>

                <label for="deskripsi">Deskripsi:</label>
                <textarea name="deskripsi" required><?php echo $event['deskripsi']; ?></textarea><br><br>

                <label for="gambar">Gambar (kosongkan jika tidak ingin mengganti gambar):</label>
                <input type="file" name="gambar"><br><br>

                <button type="submit" name="update_event" class="btn-submit">Perbarui Event</button>
            </form>
        </section>
        <?php endif; ?>

        <!-- Daftar Event Paroki -->
        <section class="info-list">
            <h2>Daftar Event Paroki</h2>
            <table>
                <tr>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
                <?php while($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['judul']; ?></td>
                        <td><?php echo $row['deskripsi']; ?></td>
                        <td><img src="../assets/images/<?php echo $row['gambar']; ?>" alt="Gambar" style="width:100px;"></td>
                        <td>
                            <a href="upload.php?edit=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                            <a href="upload.php?delete=<?php echo $row['id']; ?>" class="btn-delete">Hapus</a>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </section>

    </div>

</body>
</html>
