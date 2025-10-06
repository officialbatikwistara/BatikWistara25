<?php
include '../config/koneksi.php';
include 'header.php';

// Ambil semua kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori_produk");

// Proses ketika form disubmit
if (isset($_POST['submit'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $harga = intval($_POST['harga']);
  $id_kategori = intval($_POST['id_kategori']);
  $tanggal = date('Y-m-d');

  // Upload gambar
  $gambar = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  $folder = "../uploads/produk/";

  // Generate nama unik
  $gambar_baru = time() . '_' . $gambar;

  if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
    // Simpan ke database
    $query = mysqli_query($conn, "INSERT INTO produk (nama_produk, deskripsi, harga, gambar, tanggal_upload, id_kategori)
      VALUES ('$nama', '$deskripsi', '$harga', '$gambar_baru', '$tanggal', '$id_kategori')");

    if ($query) {
      echo "<script>alert('Produk berhasil ditambahkan!'); window.location='katalog.php';</script>";
    } else {
      echo "<script>alert('Gagal menambahkan produk.');</script>";
    }
  } else {
    echo "<script>alert('Upload gambar gagal.');</script>";
  }
}
?>

<div class="container py-5">
  <h3 class="fw-bold mb-4">Tambah Produk Baru</h3>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label for="nama_produk" class="form-label">Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="id_kategori" class="form-label">Kategori Produk</label>
      <select name="id_kategori" class="form-select" required>
        <option value="" disabled selected>-- Pilih Kategori --</option>
        <?php while ($k = mysqli_fetch_assoc($kategori)) : ?>
          <option value="<?= $k['id_kategori'] ?>"><?= $k['nama_kategori'] ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label for="harga" class="form-label">Harga</label>
      <input type="number" name="harga" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="deskripsi" class="form-label">Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
      <label for="gambar" class="form-label">Gambar Produk</label>
      <input type="file" name="gambar" class="form-control" accept="image/*" required>
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Simpan Produk</button>
    <a href="katalog.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

