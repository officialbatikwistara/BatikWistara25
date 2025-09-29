<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin - Batik Wistara</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="sidebar">
    <h3>Admin Panel</h3>
    <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">📰 Berita</a>
    <a href="katalog.php" class="<?= basename($_SERVER['PHP_SELF']) == 'katalog.php' ? 'active' : '' ?>">🧵 Katalog</a>
    <a href="logout.php" style="color: #ffcfcf;">🚪 Logout</a>
  </div>

  <div class="main-content">
