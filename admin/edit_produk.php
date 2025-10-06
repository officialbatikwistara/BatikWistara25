<?php
include '../config/koneksi.php';
include 'header.php';

// Ambil ID produk dari URL
$id = intval($_GET['id'] ?? 0);

// Cek apakah produk ditemukan
$produk = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id");
$data = mysqli_fetch_assoc($produk);
if (!$data) {
  echo "<script>alert('Produk tidak ditemukan.'); window.location='katalog.php';</script>";
  exit;
}

// Ambil semua kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori_produk");

// Proses update
if (isset($_POST['submit'])) {
  $nama = mysqli_real_escape_string($conn, $_POST['nama_produk']);
  $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $harga = intval($_POST['harga']);
  $id_kategori = intval($_POST['id_kategori']);

  // Cek apakah admin mengganti gambar
  if ($_FILES['gambar']['name']) {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $folder = "../uploads/produk/";
    $gambar_baru = time() . '_' . $gambar;

    // Hapus gambar lama
    if (file_exists($folder . $data['gambar'])) {
      unlink($folder . $data['gambar']);
    }

    // Upload gambar baru
    move_uploaded_file($tmp, $folder . $gambar_baru);

    // Update semua field + gambar
    $query = mysqli_query($conn, "UPDATE produk SET 
      nama_produk = '$nama', 
      deskripsi = '$deskripsi',
      harga = '$harga',
      gambar = '$gambar_baru',
      id_kategori = '$id_kategori'
      WHERE id_produk = $id");
  } else {
    // Update tanpa mengganti gambar
    $query = mysqli_query($conn, "UPDATE produk SET 
      nama_produk = '$nama', 
      deskripsi = '$deskripsi',
      harga = '$harga',
      id_kategori = '$id_kategori'
      WHERE id_produk = $id");
  }

  if ($query) {
    echo "<script>alert('Produk berhasil diperbarui.'); window.location='katalog.php';</script>";
  } else {
    echo "<script>alert('Gagal memperbarui produk.');</script>";
  }
}
?>

<div class="container py-5">
  <h3 class="fw-bold mb-4">Edit Produk</h3>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" value="<?= htmlspecialchars($data['nama_produk']) ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Kategori</label>
      <select name="id_kategori" class="form-select" required>
        <?php while ($k = mysqli_fetch_assoc($kategori)) : ?>
          <option value="<?= $k['id_kategori'] ?>" <?= ($k['id_kategori'] == $data['id_kategori']) ? 'selected' : '' ?>>
            <?= htmlspecialchars($k['nama_kategori']) ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Harga</label>
      <input type="number" name="harga" class="form-control" value="<?= $data['harga'] ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="4" required><?= htmlspecialchars($data['deskripsi']) ?></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Gambar Saat Ini</label><br>
      <img src="../uploads/produk/<?= $data['gambar'] ?>" width="150">
    </div>

    <div class="mb-3">
      <label class="form-label">Ganti Gambar (opsional)</label>
      <input type="file" name="gambar" class="form-control" accept="image/*">
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="katalog.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

