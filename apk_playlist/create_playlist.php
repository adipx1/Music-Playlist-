<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}
include 'config/db.php';

$title = $_POST['title'];
$artist = $_POST['artist'];
$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("INSERT INTO playlists (title, artist, user_id) VALUES (?, ?, ?)");
if (!$stmt) {
    die("Query gagal: " . $conn->error);
}
$stmt->bind_param("ssi", $title, $artist, $user_id);
$stmt->execute();
$stmt->close();

header("Location: page/dashboard.php");
exit;
?>
