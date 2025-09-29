<?php
include 'header.php';
include '../config/koneksi.php';

if (!isset($_GET['id']) && !isset($_POST['update_berita'])) {
  echo "ID berita tidak ditemukan.";
  exit;
}

$folder = "../uploads/berita/";

// ======================
// === Proses Simpan ===
// ======================
if (isset($_POST['update_berita'])) {
  $id             = $_POST['id'];
  $judul          = mysqli_real_escape_string($conn, $_POST['judul']);
  $deskripsi      = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $isi            = mysqli_real_escape_string($conn, $_POST['isi_berita']);
  $tanggal        = $_POST['tanggal'];
  $sumber         = mysqli_real_escape_string($conn, $_POST['sumber']);
  $tautan_sumber  = mysqli_real_escape_string($conn, $_POST['tautan_sumber']);

  // Ambil data lama
  $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT gambar FROM berita WHERE id_berita='$id'"));
  $gambar_lama = $old['gambar'];
  $gambar_final = $gambar_lama;

  // Jika upload gambar baru
  if (!empty($_FILES['gambar']['name'])) {
    $gambar     = $_FILES['gambar']['name'];
    $tmp        = $_FILES['gambar']['tmp_name'];
    $gambarBaru = time() . '-' . $gambar;

    move_uploaded_file($tmp, $folder . $gambarBaru);

    // Hapus gambar lama (jika bukan URL)
    if (!filter_var($gambar_lama, FILTER_VALIDATE_URL) && file_exists($folder . $gambar_lama)) {
      unlink($folder . $gambar_lama);
    }

    $gambar_final = $gambarBaru;
  }

  // Update data
  $sql = "UPDATE berita SET 
            judul='$judul',
            deskripsi='$deskripsi',
            isi_berita='$isi',
            gambar='$gambar_final',
            tanggal='$tanggal',
            sumber='$sumber',
            tautan_sumber='$tautan_sumber'
          WHERE id_berita='$id'";

  $simpan = mysqli_query($conn, $sql);
  if ($simpan) {
    header("Location: dashboard.php");
    exit;
  } else {
    echo "<p style='color:red;'>Gagal menyimpan perubahan.</p>";
  }
}

// =====================
// === Tampilkan Form ===
// =====================
$id = $_GET['id'] ?? $_POST['id'];
$data = mysqli_query($conn, "SELECT * FROM berita WHERE id_berita = '$id'");
$berita = mysqli_fetch_assoc($data);

if (!$berita) {
  echo "Data tidak ditemukan.";
  exit;
}
?>

<h2>Edit Berita</h2>

<form action="edit-berita.php" method="POST" enctype="multipart/form-data">
  <input type="hidden" name="id" value="<?= $berita['id_berita'] ?>">

  <label>Judul Berita</label>
  <input type="text" name="judul" value="<?= htmlspecialchars($berita['judul']) ?>" required>

  <label>Deskripsi Singkat</label>
  <textarea name="deskripsi" rows="3" required><?= htmlspecialchars($berita['deskripsi']) ?></textarea>

  <label>Isi Berita Lengkap</label>
  <textarea name="isi_berita" rows="6"><?= htmlspecialchars($berita['isi_berita']) ?></textarea>

  <label>Gambar Saat Ini</label><br>
  <?php if (filter_var($berita['gambar'], FILTER_VALIDATE_URL)) : ?>
    <img src="<?= $berita['gambar'] ?>" height="80">
  <?php else : ?>
    <img src="../uploads/berita/<?= $berita['gambar'] ?>" height="80">
  <?php endif; ?>
  <br><br>

  <label>Ganti Gambar (Opsional)</label>
  <input type="file" name="gambar" accept="image/*">

  <label>Tanggal</label>
  <input type="date" name="tanggal" value="<?= $berita['tanggal'] ?>" required>

  <label>Sumber Berita (Opsional)</label>
  <input type="text" name="sumber" value="<?= htmlspecialchars($berita['sumber']) ?>">

  <label>Tautan Sumber (Opsional)</label>
  <input type="url" name="tautan_sumber" value="<?= htmlspecialchars($berita['tautan_sumber']) ?>">

  <button type="submit" name="update_berita">Simpan Perubahan</button>
</form>
