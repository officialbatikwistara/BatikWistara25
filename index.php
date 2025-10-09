<?php include 'inc/header.php'; ?>
<?php include 'inc/navbar.php'; ?>

<!-- Hero Section -->
<section class="bg-light py-5 text-center text-md-start">
  <div class="container">
    <div class="row align-items-center justify-content-between flex-column-reverse flex-md-row text-center text-md-start">

      <!-- Teks Kiri -->
      <div class="col-12 col-md-6 mt-4 mt-md-0">
        <h1 class="display-5 fw-bold mb-3">
          Selamat Datang di <span class="text-gold">Batik Wistara</span>
        </h1>
        <p class="lead">
          Batik Wistara menghadirkan karya batik berkualitas tinggi, memadukan keindahan budaya dan sentuhan modern.
        </p>
        <a href="/katalog" class="btn btn-dark mt-3 px-4 py-2">Lihat Katalog</a>
      </div>

      <!-- Gambar Kanan -->
      <div class="col-12 col-md-6 mb-4 mb-md-0 text-center">
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

<!-- ======== BERITA TERKINI ======== -->
<section class="berita-section">
  <div class="container">
    <h2 class="text-center mb-5">Berita Terkini</h2>
    <div class="row g-4">
      <?php
      include './config/koneksi.php';
      $result = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC LIMIT 4");
      while ($row = mysqli_fetch_assoc($result)) {
        $gambar = $row['gambar'];
        $judul = $row['judul'];
        $deskripsi = substr($row['deskripsi'], 0, 100) . '...';
        $slug = $row['slug'];
      ?>
      <div class="col-md-3">
        <div class="card berita-card">
          <img src="<?= $gambar ?>" class="card-img-top" alt="<?= $judul ?>">
          <div class="card-body">
            <h5 class="card-title"><?= $judul ?></h5>
            <p class="card-text"><?= $deskripsi ?></p>
            <a href="detail_berita.php?slug=<?= $slug ?>" class="btn btn-outline-dark btn-sm">Baca Selengkapnya</a>
          </div>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</section>

<?php include './partials/footer.php'; ?>
<?php include 'inc/footer.php'; ?>
