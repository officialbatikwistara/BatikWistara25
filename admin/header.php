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
  <!-- Bootstrap CSS (wajib di atas) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="sidebar">
    <h3>Admin Panel</h3>
    <a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">Berita</a>
    <a href="katalog.php" class="<?= basename($_SERVER['PHP_SELF']) == 'katalog.php' ? 'active' : '' ?>">Katalog</a>
    <a href="kategori.php" class="<?= basename($_SERVER['PHP_SELF']) == 'kategori.php' ? 'active' : '' ?>">Kategori</a>
    <a href="logout.php" style="color: #ffcfcf;">🚪 Logout</a>
  </div>

  <div class="main-content">
