<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<?php
function slugify($text) {
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  $text = preg_replace('~[^-\w]+~', '', $text);
  $text = trim($text, '-');
  $text = preg_replace('~-+~', '-', $text);
  $text = strtolower($text);
  return empty($text) ? 'berita-' . time() : $text;
}

if (isset($_POST['simpan_berita'])) {
  $judul         = mysqli_real_escape_string($conn, $_POST['judul']);
  $slug          = slugify($judul);
  $deskripsi     = mysqli_real_escape_string($conn, $_POST['deskripsi']);
  $isi           = mysqli_real_escape_string($conn, $_POST['isi_berita']);
  $tanggal       = $_POST['tanggal'];
  $sumber        = mysqli_real_escape_string($conn, $_POST['sumber']);
  $tautan_sumber = mysqli_real_escape_string($conn, $_POST['tautan_sumber']);
  $gambar_link   = mysqli_real_escape_string($conn, $_POST['gambar_url']);
  $gambar_final  = '';

  if (!empty($_FILES['gambar']['name'])) {
    $gambar   = $_FILES['gambar']['name'];
    $tmp      = $_FILES['gambar']['tmp_name'];
    $folder   = "../uploads/berita/";
    $gambarBaru = time() . '-' . $gambar;
    move_uploaded_file($tmp, $folder . $gambarBaru);
    $gambar_final = $gambarBaru;
  } elseif (!empty($gambar_link)) {
    $gambar_final = $gambar_link;
  }

  $query = mysqli_query($conn, "INSERT INTO berita 
    (judul, slug, deskripsi, isi_berita, gambar, tanggal, sumber, tautan_sumber)
    VALUES 
    ('$judul', '$slug', '$deskripsi', '$isi', '$gambar_final', '$tanggal', '$sumber', '$tautan_sumber')");

  if ($query) {
    header("Location: dashboard.php");
    exit;
  } else {
    echo "<p style='color:red;'>Gagal menambahkan berita.</p>";
  }
}
?>

<div class="form-container">
  <h1>Tambah Berita</h1>

  <form action="" method="POST" enctype="multipart/form-data" class="form-grid">
    <div>
      <label>Judul</label>
      <input type="text" name="judul" required>
    </div>

    <div>
      <label>Deskripsi Singkat</label>
      <textarea name="deskripsi" rows="3" required></textarea>
    </div>

    <div style="grid-column: span 2;">
      <label>Isi Berita (boleh kosong jika eksternal)</label>
      <textarea name="isi_berita" rows="6"></textarea>
    </div>

    <div>
      <label>Upload Gambar (opsional)</label>
      <input type="file" name="gambar">
    </div>

    <div>
      <label>Link Gambar (jika eksternal)</label>
      <input type="url" name="gambar_url" placeholder="https://...">
    </div>

    <div>
      <label>Tanggal</label>
      <input type="date" name="tanggal" required>
    </div>

    <div>
      <label>Sumber Berita (opsional)</label>
      <input type="text" name="sumber">
    </div>

    <div style="grid-column: span 2;">
      <label>Tautan Sumber (opsional)</label>
      <input type="url" name="tautan_sumber" placeholder="https://...">
    </div>

    <div style="grid-column: span 2; text-align: center;">
      <button type="submit" name="simpan_berita">Simpan</button>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>