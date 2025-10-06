<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<?php

// Proses jika form disubmit
if (isset($_POST['submit'])) {
  $nama_kategori = mysqli_real_escape_string($conn, $_POST['nama_kategori']);

  // Cek apakah kategori sudah ada
  $cek = mysqli_query($conn, "SELECT * FROM kategori_produk WHERE nama_kategori = '$nama_kategori'");
  if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Kategori sudah ada.');</script>";
  } else {
    $simpan = mysqli_query($conn, "INSERT INTO kategori_produk (nama_kategori) VALUES ('$nama_kategori')");
    if ($simpan) {
      echo "<script>alert('Kategori berhasil ditambahkan!'); window.location='kategori.php';</script>";
    } else {
      echo "<script>alert('Gagal menambahkan kategori.');</script>";
    }
  }
}
?>

<div class="container py-5">
  <h3 class="fw-bold mb-4">Tambah Kategori Produk</h3>

  <form method="POST">
    <div class="mb-3">
      <label class="form-label">Nama Kategori</label>
      <input type="text" name="nama_kategori" class="form-control" placeholder="Contoh: Dress Wanita" required>
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Simpan Kategori</button>
    <a href="kategori.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<?php include 'footer.php'; ?>
