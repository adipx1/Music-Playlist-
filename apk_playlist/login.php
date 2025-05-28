<?php
session_start();
include 'config/db.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $db_pass);
        $stmt->fetch();

        // Verifikasi password yang sudah di-hash
        if (password_verify($password, $db_pass)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user'] = $username;
            header("Location: page/dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "User tidak ditemukan!";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Login - Save Your Playlist Here</title>
<style>
    /* Reset & Base */
    * {
        margin: 0; padding: 0; box-sizing: border-box;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    body {
        height: 100vh;
        position: relative;
        background: url('asset/bglagu6.jpg') no-repeat center center fixed;
        background-size: cover;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        overflow: hidden;
    }

    /* Overlay gelap supaya teks jelas */
    body::before {
        content: '';
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 0;
    }

    /* Container */
    .login-container {
        position: relative;
        z-index: 1;
        background: rgba(0,0,0,0.7);
        padding: 40px 35px;
        border-radius: 15px;
        width: 350px;
        box-shadow: 0 0 25px rgba(0,0,0,0.5);
        text-align: center;
    }

    /* Title */
    .login-container h2 {
        margin-bottom: 30px;
        font-weight: 700;
        font-size: 28px;
        letter-spacing: 1.2px;
        color: #e0e0e0;
    }

    /* Error message */
    .error {
        background-color: #e74c3c;
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 8px;
        font-weight: 600;
        color: white;
    }

    /* Form */
    form {
        display: flex;
        flex-direction: column;
    }
    form input {
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 10px;
        border: none;
        font-size: 16px;
        outline: none;
        transition: box-shadow 0.3s ease;
        color: #222;
    }
    form input:focus {
        box-shadow: 0 0 8px #8ab4f8;
    }

    /* Button */
    form button {
        background: #84b9ff;
        border: none;
        padding: 14px;
        border-radius: 12px;
        font-weight: 700;
        font-size: 18px;
        cursor: pointer;
        color: #222;
        transition: background-color 0.3s ease;
    }
    form button:hover {
        background: #5a9fff;
    }

    /* Link to register */
    .register-link {
        margin-top: 15px;
        font-size: 14px;
        color: #ccc;
    }
    .register-link a {
        color: #84b9ff;
        text-decoration: none;
    }
    .register-link a:hover {
        text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 400px) {
        .login-container {
            width: 90vw;
            padding: 30px 25px;
        }
    }
</style>
</head>
<body>

<div class="login-container">
    <h2>Save ur playlist here</h2>

    <?php if($error): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required autocomplete="off" />
        <input type="password" name="password" placeholder="Password" required autocomplete="off" />
        <button type="submit">Login</button>
    </form>

    <p class="register-link">
      Belum punya akun? <a href="register.php">Daftar di sini</a>
    </p>
</div>

</body>
</html>
