<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

include '../config/db.php';

$user_id = $_SESSION['user_id'];
$username = $_SESSION['user'];

// Proses hapus lagu jika ada request POST 'delete_id'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = intval($_POST['delete_id']);

    // Hapus lagu yang punya user_id sama dengan session user_id dan id = $delete_id
    $stmt_del = $conn->prepare("DELETE FROM playlists WHERE id = ? AND user_id = ?");
    $stmt_del->bind_param("ii", $delete_id, $user_id);
    $stmt_del->execute();

    if ($stmt_del->affected_rows > 0) {
        $message = "Lagu berhasil dihapus.";
    } else {
        $message = "Gagal menghapus lagu atau lagu tidak ditemukan.";
    }
    $stmt_del->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Playlist <?= htmlspecialchars($username) ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('../asset/bglagu3.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #fff;
        }

        .container {
            max-width: 700px;
            margin: 80px auto;
            background: rgba(0, 0, 0, 0.75);
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .nav-links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #84b9ff;
            color: #000;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
            cursor: pointer;
        }

        .btn.logout {
            background-color: #f97171;
        }

        .btn:hover {
            background-color: #5a9fff;
        }

        .playlist-section ul {
            list-style: none;
            padding: 0;
        }

        .playlist-section li {
            background: rgba(255, 255, 255, 0.1);
            padding: 12px;
            margin-bottom: 10px;
            border-radius: 8px;
            font-size: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .playlist-section li strong {
            color: #90ee90;
        }

        /* Tombol hapus */
        form.delete-form {
            margin: 0;
        }

        form.delete-form button {
            background-color: #e74c3c;
            border: none;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        form.delete-form button:hover {
            background-color: #c0392b;
        }

        /* Pesan hapus */
        .message {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            background-color: #27ae60;
            border-radius: 8px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>🎧 Playlist Milik <?= htmlspecialchars($username) ?></h2>

        <div class="nav-links">
            <a href="dashboard.php" class="btn">⬅ Kembali</a>
            <a href="logout.php" class="btn logout">🚪 Logout</a>
        </div>

        <?php if (!empty($message)): ?>
            <div class="message"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <div class="playlist-section">
            <ul>
                <?php
                $stmt = $conn->prepare("SELECT id, title, artist FROM playlists WHERE user_id = ?");
                if (!$stmt) {
                    die("Query error: " . $conn->error);
                }
                $stmt->bind_param("i", $user_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<li>";
                        echo "<strong>" . htmlspecialchars($row['title']) . "</strong> - " . htmlspecialchars($row['artist']);
                        // Form hapus
                        echo '<form class="delete-form" method="POST" onsubmit="return confirm(\'Yakin ingin menghapus lagu ini?\');">';
                        echo '<input type="hidden" name="delete_id" value="' . $row['id'] . '">';
                        echo '<button type="submit">Hapus</button>';
                        echo '</form>';
                        echo "</li>";
                    }
                } else {
                    echo "<li>🎶 Belum ada lagu di playlist Anda.</li>";
                }
                $stmt->close();
                ?>
            </ul>
        </div>
    </div>
</body>
</html>
