<?php
session_start();
include 'config/db.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Ambil data user berdasarkan username dan password (jangan lupa hash password sebenarnya)
$query = $conn->prepare("SELECT id, username FROM users WHERE username=? AND password=?");
$query->bind_param("ss", $username, $password);
$query->execute();
$result = $query->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $_SESSION['user'] = $user['username'];
    $_SESSION['user_id'] = $user['id'];  // simpan user_id di session

    header("Location: page/dashboard.php");
} else {
    echo "<script>alert('Login gagal');window.location='index.php';</script>";
}

$query->close();
$conn->close();
?>
