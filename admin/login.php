<?php
session_start();
include('../db.php');

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Enkripsi password dengan MD5 sebelum melakukan pencocokan
    $hashed_password = md5($password);

    // Membuat prepared statement untuk mencegah SQL Injection
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
    
    // Bind parameter (ss = string, string)
    $stmt->bind_param("ss", $username, $hashed_password);  

    // Menjalankan query
    $stmt->execute();

    // Menyimpan hasil query
    $result = $stmt->get_result();

    // Mengecek apakah data ditemukan
    if ($result->num_rows > 0) {
        // Login berhasil, set session dan redirect
        $_SESSION['admin'] = $username;  // Set session untuk admin
        header('Location: upload.php');  // Redirect ke upload.php
        exit();  // Pastikan untuk menghentikan eksekusi kode setelah header
    } else {
        // Jika login gagal, panggil showError untuk menampilkan pop-up
        echo "<script>showError();</script>";
    }

    // Menutup statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <link rel="stylesheet" href="../css/style2.css"> <!-- Link ke CSS -->
</head>
<body>
    <div class="container">
        <h1>Login Admin</h1>
        <form method="POST">
            Username: <input type="text" name="username" required><br><br>
            Password: <input type="password" name="password" required><br><br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>

    <!-- Pop-up Error Message -->
    <div id="popupMessage" class="popup-message">
        Username atau Password salah!
    </div>

    <!-- JavaScript untuk menampilkan pesan error -->
    <script>
        function showError() {
            var popup = document.getElementById('popupMessage');
            popup.style.display = 'block'; // Menampilkan pop-up
            setTimeout(function() {
                popup.style.display = 'none'; // Menyembunyikan pop-up setelah 3 detik
            }, 3000);
        }
    </script>
</body>
</html>
