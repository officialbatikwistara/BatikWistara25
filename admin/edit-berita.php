<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<?php
if (!isset($_GET['id']) && !isset($_POST['update_berita'])) {
  echo "<div class='container py-4'><div class='alert alert-danger'><i class='bi bi-exclamation-circle'></i> ID berita tidak ditemukan.</div></div>";
  exit;
}

$folder = "../uploads/berita/";
$success_message = "";
$error_message = "";

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

    if (move_uploaded_file($tmp, $folder . $gambarBaru)) {
      if (!filter_var($gambar_lama, FILTER_VALIDATE_URL) && file_exists($folder . $gambar_lama)) {
        unlink($folder . $gambar_lama);
      }
      $gambar_final = $gambarBaru;
    } else {
      $error_message = "Gagal mengupload gambar.";
    }
  }

  if (empty($error_message)) {
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
      $success_message = "Berita berhasil diperbarui!";
      echo "<script>setTimeout(function(){ window.location.href='dashboard.php'; }, 2000);</script>";
    } else {
      $error_message = "Gagal menyimpan perubahan: " . mysqli_error($conn);
    }
  }
}

// =====================
// === Tampilkan Form ===
// =====================
$id = $_GET['id'] ?? $_POST['id'];
$data = mysqli_query($conn, "SELECT * FROM berita WHERE id_berita = '$id'");
$berita = mysqli_fetch_assoc($data);

if (!$berita) {
  echo "<div class='container py-4'><div class='alert alert-danger'><i class='bi bi-exclamation-circle'></i> Data tidak ditemukan.</div></div>";
  exit;
}
?>

<div class="container py-5">
  <!-- Page Header Card -->
  <div class="card page-header-card border-0 shadow-lg mb-4">
    <div class="card-body">
      <h2>
        <i class="bi bi-pencil-square"></i>
        <span>Edit Berita</span>
      </h2>
      <p class="form-subtitle mb-0">Perbarui informasi berita dengan mengisi form di bawah ini</p>
    </div>
  </div>

  <!-- Alert Messages -->
  <?php if (!empty($success_message)): ?>
  <div class="alert alert-success shadow">
    <i class="bi bi-check-circle-fill"></i>
    <span><?= $success_message ?></span>
  </div>
  <?php endif; ?>

  <?php if (!empty($error_message)): ?>
  <div class="alert alert-danger shadow">
    <i class="bi bi-exclamation-circle-fill"></i>
    <span><?= $error_message ?></span>
  </div>
  <?php endif; ?>

  <!-- Main Form Card -->
  <div class="card form-main-card border-0 shadow-lg">
    <div class="card-body">
      <form action="edit-berita.php" method="POST" enctype="multipart/form-data" id="editBeritaForm">
        <input type="hidden" name="id" value="<?= $berita['id_berita'] ?>">

        <!-- Section: Informasi Dasar -->
        <div class="section-card">
          <div class="section-title">
            <i class="bi bi-info-circle-fill"></i>
            Informasi Dasar
          </div>

          <!-- Judul Berita -->
          <div class="form-group">
            <label>
              <i class="bi bi-fonts"></i>
              Judul Berita
              <span class="required">*</span>
              <span class="info-badge">
                <i class="bi bi-star-fill"></i>
                Wajib
              </span>
            </label>
            <input type="text" 
                   name="judul" 
                   class="form-control" 
                   value="<?= htmlspecialchars($berita['judul']) ?>" 
                   placeholder="Masukkan judul berita yang menarik dan deskriptif"
                   required
                   maxlength="200"
                   id="judulInput">
            <div class="char-counter">
              <i class="bi bi-hash"></i>
              <span id="judulCounter">0</span>/200 karakter
            </div>
          </div>

          <!-- Deskripsi Singkat -->
          <div class="form-group">
            <label>
              <i class="bi bi-card-text"></i>
              Deskripsi Singkat
              <span class="required">*</span>
              <span class="info-badge">
                <i class="bi bi-star-fill"></i>
                Wajib
              </span>
            </label>
            <textarea name="deskripsi" 
                      class="form-control" 
                      rows="4" 
                      placeholder="Tulis ringkasan singkat yang menarik untuk muncul di preview berita"
                      required
                      maxlength="250"
                      id="deskripsiInput"><?= htmlspecialchars($berita['deskripsi']) ?></textarea>
            <div class="char-counter">
              <i class="bi bi-hash"></i>
              <span id="deskripsiCounter">0</span>/250 karakter
            </div>
            <div class="form-help-box">
              <i class="bi bi-lightbulb-fill"></i>
              <span>Deskripsi ini akan muncul sebagai preview di halaman daftar berita</span>
            </div>
          </div>
        </div>

        <hr class="section-divider">

        <!-- Section: Konten Berita -->
        <div class="section-card">
          <div class="section-title">
            <i class="bi bi-file-text-fill"></i>
            Konten Berita
          </div>

          <!-- Isi Berita Lengkap -->
          <div class="form-group">
            <label>
              <i class="bi bi-newspaper"></i>
              Isi Berita Lengkap
              <span class="label-optional">Opsional</span>
            </label>
            <textarea name="isi_berita" 
                      class="form-control" 
                      rows="10"
                      placeholder="Tulis isi berita secara lengkap dan detail di sini..."><?= htmlspecialchars($berita['isi_berita']) ?></textarea>
            <div class="form-help-box warning">
              <i class="bi bi-info-circle-fill"></i>
              <span>Kosongkan jika berita menggunakan tautan eksternal dari sumber lain</span>
            </div>
          </div>
        </div>

        <hr class="section-divider">

        <!-- Section: Media & Gambar -->
        <div class="section-card">
          <div class="section-title">
            <i class="bi bi-image-fill"></i>
            Media & Gambar
          </div>

          <!-- Gambar Saat Ini -->
          <div class="form-group">
            <label>
              <i class="bi bi-eye-fill"></i>
              Preview Gambar Saat Ini
            </label>
            <div class="card image-preview-card border-0 shadow">
              <div class="card-body">
                <div class="image-preview-label">
                  <i class="bi bi-image"></i>
                  <span>Gambar Berita</span>
                </div>
                <?php if (filter_var($berita['gambar'], FILTER_VALIDATE_URL)): ?>
                  <img src="<?= $berita['gambar'] ?>" alt="Preview" id="imagePreview" class="img-fluid">
                <?php else: ?>
                  <img src="../uploads/berita/<?= $berita['gambar'] ?>" alt="Preview" id="imagePreview" class="img-fluid">
                <?php endif; ?>
              </div>
            </div>
          </div>

          <!-- Upload Gambar Baru -->
          <div class="form-group">
            <label>
              <i class="bi bi-cloud-upload-fill"></i>
              Ganti Gambar
              <span class="label-optional">Opsional</span>
            </label>
            <input type="file" 
                   name="gambar" 
                   class="form-control"
                   accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                   id="gambarInput">
            <div class="form-help-box">
              <i class="bi bi-info-circle-fill"></i>
              <span>Format yang didukung: JPG, JPEG, PNG, GIF, WEBP | Ukuran maksimal: 5MB</span>
            </div>
          </div>
        </div>

        <hr class="section-divider">

      <!-- Row: Tanggal -->
      <div class="form-row">
        <div class="form-group">
          <label>
            <i class="bi bi-calendar-event"></i>
            Tanggal Publikasi <span class="required">*</span>
          </label>
          <input type="date" 
                 name="tanggal" 
                 class="form-control"
                 value="<?= $berita['tanggal'] ?>" 
                 required>
        </div>

        <div class="form-group">
          <label>
            <i class="bi bi-building"></i>
            Sumber Berita <span class="label-optional">(Opsional)</span>
          </label>
          <input type="text" 
                 name="sumber" 
                 class="form-control"
                 value="<?= htmlspecialchars($berita['sumber']) ?>"
                 placeholder="Contoh: Kompas.com, CNN Indonesia">
        </div>
      </div>

      <!-- Tautan Sumber -->
      <div class="form-group">
        <label>
          <i class="bi bi-link-45deg"></i>
          Tautan Sumber <span class="label-optional">(Opsional)</span>
        </label>
        <input type="url" 
               name="tautan_sumber" 
               class="form-control"
               value="<?= htmlspecialchars($berita['tautan_sumber']) ?>"
               placeholder="https://example.com/artikel">
        <div class="form-help-text">
          <i class="bi bi-info-circle"></i>
          Jika diisi, tombol "Baca Selengkapnya" akan mengarah ke link ini
        </div>
      </div>

      <!-- Button Group -->
      <div class="button-group">
        <button type="submit" name="update_berita" class="btn-primary">
          <i class="bi bi-save"></i>
          Simpan Perubahan
        </button>
        <a href="dashboard.php" class="btn-secondary">
          <i class="bi bi-x-circle"></i>
          Batal
        </a>
      </div>
    </form>
  </div>
</div>

<script>
// Character Counter
function updateCounter(inputId, counterId, maxLength) {
  const input = document.getElementById(inputId);
  const counter = document.getElementById(counterId);
  
  function update() {
    const length = input.value.length;
    counter.textContent = length;
    
    if (length > maxLength * 0.9) {
      counter.style.color = '#DC3545';
    } else if (length > maxLength * 0.7) {
      counter.style.color = '#f59e0b';
    } else {
      counter.style.color = '#6C757D';
    }
  }
  
  input.addEventListener('input', update);
  update(); // Initial count
}

updateCounter('judulInput', 'judulCounter', 200);
updateCounter('deskripsiInput', 'deskripsiCounter', 250);

// Image Preview
document.getElementById('gambarInput').addEventListener('change', function(e) {
  const file = e.target.files[0];
  if (file) {
    // Validate file size (5MB)
    if (file.size > 5 * 1024 * 1024) {
      alert('Ukuran file terlalu besar! Maksimal 5MB');
      this.value = '';
      return;
    }
    
    // Validate file type
    const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    if (!validTypes.includes(file.type)) {
      alert('Format file tidak didukung! Gunakan JPG, PNG, GIF, atau WEBP');
      this.value = '';
      return;
    }
    
    // Show preview
    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('imagePreview').src = e.target.result;
    }
    reader.readAsDataURL(file);
  }
});

// Form Submit Loading State
document.getElementById('editBeritaForm').addEventListener('submit', function(e) {
  const submitBtn = this.querySelector('button[type="submit"]');
  submitBtn.classList.add('btn-loading');
  submitBtn.disabled = true;
});

// Auto hide alert after 5 seconds
setTimeout(function() {
  const alerts = document.querySelectorAll('.alert');
  alerts.forEach(alert => {
    alert.style.transition = 'opacity 0.5s';
    alert.style.opacity = '0';
    setTimeout(() => alert.remove(), 500);
  });
}, 5000);
</script>

<?php include 'footer.php'; ?>