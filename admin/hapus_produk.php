<?php
include '../config/koneksi.php';

// Cek apakah ada ID yang dikirim
if (isset($_GET['id'])) {
  $id = intval($_GET['id']);

  // Ambil data produk untuk menghapus file gambar
  $get = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id");
  $data = mysqli_fetch_assoc($get);

  if ($data) {
    // Hapus gambar jika ada
    $gambar_path = "../uploads/produk/" . $data['gambar'];
    if (file_exists($gambar_path)) {
      unlink($gambar_path); // hapus file gambar
    }

    // Hapus data dari database
    $delete = mysqli_query($conn, "DELETE FROM produk WHERE id_produk = $id");

    if ($delete) {
      echo "<script>alert('Produk berhasil dihapus.'); window.location='katalog.php';</script>";
    } else {
      echo "<script>alert('Gagal menghapus produk.'); window.location='katalog.php';</script>";
    }
  } else {
    echo "<script>alert('Produk tidak ditemukan.'); window.location='katalog.php';</script>";
  }
} else {
  echo "<script>alert('ID tidak valid.'); window.location='katalog.php';</script>";
}
?>
