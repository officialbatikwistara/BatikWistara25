<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<?php

$kategori = mysqli_query($conn, "SELECT * FROM kategori_produk");

if (isset($_POST['submit'])) {
  $nama         = trim(mysqli_real_escape_string($conn, $_POST['nama_produk']));
  $deskripsi    = trim(mysqli_real_escape_string($conn, $_POST['deskripsi']));
  $harga        = intval($_POST['harga']);
  $id_kategori  = intval($_POST['id_kategori']);
  $link_shopee  = mysqli_real_escape_string($conn, $_POST['link_shopee']);
  $link_tiktok  = mysqli_real_escape_string($conn, $_POST['link_tiktok']);
  $tanggal      = date('Y-m-d');

  // Upload gambar
  $gambar = $_FILES['gambar']['name'];
  $tmp = $_FILES['gambar']['tmp_name'];
  $folder = "../uploads/produk/";
  $ext = pathinfo($gambar, PATHINFO_EXTENSION);
  $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
  $gambar_baru = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $gambar);

  if (in_array(strtolower($ext), $allowed_ext)) {
    if (move_uploaded_file($tmp, $folder . $gambar_baru)) {
      // Simpan ke database
      $query = mysqli_query($conn, "INSERT INTO produk 
        (nama_produk, deskripsi, harga, gambar, tanggal_upload, id_kategori, link_shopee, link_tiktok)
        VALUES ('$nama', '$deskripsi', '$harga', '$gambar_baru', '$tanggal', '$id_kategori', '$link_shopee', '$link_tiktok')");

      if ($query) {
        echo "<script>alert('Produk berhasil ditambahkan!'); window.location='katalog.php';</script>";
      } else {
        echo "<div class='alert alert-danger'>Gagal menyimpan ke database.</div>";
      }
    } else {
      echo "<div class='alert alert-warning'>Upload gambar gagal.</div>";
    }
  } else {
    echo "<div class='alert alert-danger'>Format gambar tidak valid. (Hanya JPG, PNG, JPEG, WEBP)</div>";
  }
}
?>

<div class="container py-5">
  <h3 class="fw-bold mb-4">Tambah Produk Baru</h3>

  <form method="POST" enctype="multipart/form-data">
    <div class="mb-3">
      <label class="form-label">Nama Produk</label>
      <input type="text" name="nama_produk" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Kategori Produk</label>
      <select name="id_kategori" class="form-select" required>
        <option value="" disabled selected>-- Pilih Kategori --</option>
        <?php while ($k = mysqli_fetch_assoc($kategori)) : ?>
          <option value="<?= $k['id_kategori'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Harga</label>
      <input type="number" name="harga" class="form-control" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Deskripsi</label>
      <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">Gambar Produk</label>
      <input type="file" name="gambar" class="form-control" accept="image/*" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Link Shopee (opsional)</label>
      <input type="url" name="link_shopee" class="form-control" placeholder="https://shopee.co.id/produk-anda">
    </div>

    <div class="mb-3">
      <label class="form-label">Link TikTokShop (opsional)</label>
      <input type="url" name="link_tiktok" class="form-control" placeholder="https://www.tiktok.com/@tokoanda/video/...">
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Simpan Produk</button>
    <a href="katalog.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<?php include 'footer.php'; ?>
