<?php include 'inc/header.php'; ?>
<?php include 'inc/navbar.php'; ?>

<!-- Hero Section -->
<section class="bg-light py-5 text-center text-md-start">
  <div class="container">
    <div class="row align-items-center">
      <!-- Teks Kiri -->
      <div class="col-md-6 mb-4 mb-md-0">
        <h1 class="display-5 fw-bold mb-3">Selamat Datang di <span class="text-gold">Batik Wistara</span></h1>
        <p class="lead">Batik Wistara menghadirkan karya batik berkualitas tinggi, memadukan keindahan budaya dan sentuhan modern.</p>
        <a href="/katalog" class="btn btn-dark mt-3 px-4 py-2">Lihat Katalog</a>
      </div>

      <!-- Gambar Kanan -->
      <div class="col-md-6 text-center">
        <img src="./img/logowarna.png" alt="Batik Wistara" class="img-fluid" style="max-height: 400px;">
      </div>
    </div>
  </div>
</section>

<!-- Tentang Singkat -->
<section class="section-about-img text-center">
  <div class="container-about-img">
    <h2 class="mb-3 fw-bold ">Tentang Kami</h2>
    <hr class="divider">
    <p class="about-text">
      Sejak awal berdiri, <strong>Batik Wistara</strong> berkomitmen menjaga warisan batik Nusantara melalui desain yang autentik dan kualitas premium.
      Koleksi kami mencakup beragam motif, mulai dari klasik penuh makna hingga gaya modern yang elegan.
    </p>
    <a href="/about" class="about-button">Selengkapnya</a>
  </div>
</section>

<!-- Berita Terkini -->
<?php include './config/koneksi.php'; ?>
<section class="section-berita">
  <div class="container-berita">
    <h2 class="berita-title">Berita Terkini</h2>
    <hr class="berita-divider">

    <div class="berita-grid">
      <?php
      $berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 4");
      while ($b = mysqli_fetch_array($berita)) :
      ?>
        <div class="berita-card">
          <!-- Gambar + sumber overlay -->
          <div class="berita-img-wrapper">
            <?php if (filter_var($b['gambar'], FILTER_VALIDATE_URL)) : ?>
              <img src="<?= $b['gambar'] ?>" alt="<?= $b['judul'] ?>">
            <?php else : ?>
              <img src="uploads/berita/<?= $b['gambar'] ?>" alt="<?= $b['judul'] ?>">
            <?php endif; ?>

            <div class="berita-sumber-overlay">
              <?php if (!empty($b['sumber'])): ?>
                Sumber: <?= htmlspecialchars($b['sumber']) ?>
              <?php endif; ?>
            </div>
          </div>

          <!-- Judul & Deskripsi -->
          <h3 class="berita-judul"><?= $b['judul'] ?></h3>
          <p class="berita-deskripsi"><?= $b['deskripsi'] ?></p>

          <!-- Link -->
          <?php if (!empty($b['tautan_sumber'])): ?>
            <a href="<?= $b['tautan_sumber'] ?>" target="_blank" class="berita-link">Baca Selengkapnya →</a>
          <?php else: ?>
            <a href="/berita/<?= $b['slug'] ?>" class="berita-link">Baca Selengkapnya →</a>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Tombol lihat semua -->
    <div class="berita-footer">
      <a href="berita" class="btn-lihat-semua">Lihat Semua Berita</a>
    </div>
  </div>
</section>


<?php include 'inc/footer.php'; ?>
