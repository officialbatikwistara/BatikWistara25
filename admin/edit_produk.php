<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<?php
$id = intval($_GET['id'] ?? 0);
$produk = mysqli_query($conn, "SELECT * FROM produk WHERE id_produk = $id");
$data = mysqli_fetch_assoc($produk);

if (!$data) {
  echo "<script>alert('Produk tidak ditemukan.'); window.location='katalog.php';</script>";
  exit;
}

$kategori = mysqli_query($conn, "SELECT * FROM kategori_produk");

if (isset($_POST['submit'])) {
  $nama         = trim(mysqli_real_escape_string($conn, $_POST['nama_produk']));
  $deskripsi    = trim(mysqli_real_escape_string($conn, $_POST['deskripsi']));
  $harga        = intval($_POST['harga']);
  $id_kategori  = intval($_POST['id_kategori']);
  $link_shopee  = mysqli_real_escape_string($conn, $_POST['link_shopee']);
  $link_tiktok  = mysqli_real_escape_string($conn, $_POST['link_tiktok']);
  $folder       = "../uploads/produk/";
  $gambar_baru  = $data['gambar']; // default gambar lama

  // Jika upload gambar baru
  if ($_FILES['gambar']['name']) {
    $gambar = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $ext = pathinfo($gambar, PATHINFO_EXTENSION);
    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
    $new_name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '_', $gambar);

    if (in_array(strtolower($ext), $allowed_ext)) {
      // Hapus gambar lama
      if (!empty($data['gambar']) && file_exists($folder . $data['gambar'])) {
        unlink($folder . $data['gambar']);
      }

      // Upload gambar baru
      if (move_uploaded_file($tmp, $folder . $new_name)) {
        $gambar_baru = $new_name;
      } else {
        echo "<script>alert('Gagal upload gambar baru');</script>";
      }
    } else {
      echo "<script>alert('Format gambar tidak valid');</script>";
    }
  }

  // Update data ke database
  $query = mysqli_query($conn, "UPDATE produk SET 
    nama_produk = '$nama', 
    deskripsi = '$deskripsi',
    harga = '$harga',
    gambar = '$gambar_baru',
    id_kategori = '$id_kategori',
    link_shopee = '$link_shopee',
    link_tiktok = '$link_tiktok'
    WHERE id_produk = $id");

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
      <label class="form-label">Link Shopee</label>
      <input type="url" name="link_shopee" class="form-control" value="<?= htmlspecialchars($data['link_shopee'] ?? '') ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Link TikTokShop</label>
      <input type="url" name="link_tiktok" class="form-control" value="<?= htmlspecialchars($data['link_tiktok'] ?? '') ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Gambar Saat Ini</label><br>
      <img src="../uploads/produk/<?= htmlspecialchars($data['gambar']) ?>" width="150" class="img-thumbnail">
    </div>

    <div class="mb-3">
      <label class="form-label">Ganti Gambar (opsional)</label>
      <input type="file" name="gambar" class="form-control" accept="image/*">
    </div>

    <button type="submit" name="submit" class="btn btn-primary">Simpan Perubahan</button>
    <a href="katalog.php" class="btn btn-secondary">Kembali</a>
  </form>
</div>

<?php include 'footer.php'; ?>