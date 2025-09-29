<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}

include '../config/koneksi.php';

if (!isset($_GET['id'])) {
  echo "ID berita tidak ditemukan.";
  exit;
}

$id = $_GET['id'];

// Ambil data gambar terlebih dahulu
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM berita WHERE id_berita = '$id'"));
$gambar = $data['gambar'] ?? null;

// Hapus file gambar jika ada
if ($gambar && file_exists("../uploads/berita/$gambar")) {
  unlink("../uploads/berita/$gambar");
}

// Hapus dari database
mysqli_query($conn, "DELETE FROM berita WHERE id_berita = '$id'");

// Kembali ke dashboard
header("Location: dashboard.php");
exit;
