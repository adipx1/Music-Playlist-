<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}
$username = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <title>Dashboard</title>
    <link rel="stylesheet" href="../css/style.css" />
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('../asset/bglagu3.jpg'); /* Ganti sesuai lokasi gambar */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            background-attachment: fixed;
            color: #fff;
            min-height: 100vh;
        }

        .container {
            background-color: rgba(0, 0, 0, 0.85); /* Lebih gelap dari sebelumnya */
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 0 25px rgba(0,0,0,0.5);
            text-align: center;
        }

        h2 {
            font-size: 26px;
            margin-bottom: 20px;
        }

        .nav-links {
            margin-bottom: 30px;
        }

        .btn {
            background-color: #84b9ff;
            color: #222;
            padding: 12px 18px;
            margin: 10px;
            text-decoration: none;
            font-weight: bold;
            border-radius: 10px;
            transition: background-color 0.3s ease;
            display: inline-block;
        }

        .btn.logout {
            background-color: #e74c3c;
            color: white;
        }

        .btn:hover {
            background-color: #5a9fff;
        }

        .form-section {
            text-align: left;
            margin-top: 20px;
        }

        .form-section h3 {
            margin-bottom: 15px;
            font-size: 20px;
            color: #f1f1f1;
        }

        form input, form button {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: none;
            font-size: 16px;
        }

        form input {
            background-color: #f1f1f1;
            color: #222;
        }

        form button {
            background-color: #00d4ff;
            color: black;
            font-weight: bold;
            cursor: pointer;
        }

        form button:hover {
            background-color: #00aee6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎵 Selamat Datang, <?= htmlspecialchars($username) ?>!</h2>
        
        <div class="nav-links">
            <a href="playlist.php" class="btn">🎧 Lihat Playlist Saya</a>
            <a href="logout.php" class="btn logout">🚪 Logout</a>
        </div>

        <div class="form-section">
            <h3>➕ Tambahkan Lagu Baru ke Playlist</h3>
            <form action="../create_playlist.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="title" placeholder="Judul Lagu" required />
                <input type="text" name="artist" placeholder="Artis" required />
                <button type="submit">Tambah Lagu</button>
            </form>
        </div>
    </div>
</body>
</html>
