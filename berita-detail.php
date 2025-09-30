<?php
include 'config/koneksi.php';

$base_url = 'https://yourdomain.com'; // ganti sesuai domain kamu

if (!isset($_GET['id'])) {
  $meta_title = "Berita Tidak Ditemukan - Batik Wistara";
  $meta_description = "Berita tidak tersedia atau telah dihapus.";
  $meta_canonical = $base_url . '/berita.php';
} else {
  $id = intval($_GET['id']);
  $query = mysqli_query($conn, "SELECT * FROM berita WHERE id_berita = $id");

  if (mysqli_num_rows($query) == 0) {
    $meta_title = "Berita Tidak Ditemukan - Batik Wistara";
    $meta_description = "Berita tidak tersedia atau telah dihapus.";
    $meta_canonical = $base_url . '/berita.php';
  } else {
    $berita = mysqli_fetch_assoc($query);
    $meta_title       = $berita['judul'] . " - Batik Wistara";
    $meta_description = mb_substr(strip_tags($berita['deskripsi']), 0, 160);
    $meta_canonical   = $base_url . "/berita-detail.php?id=" . $berita['id_berita'];
    $og_image         = !empty($berita['gambar']) ?
      (filter_var($berita['gambar'], FILTER_VALIDATE_URL)
        ? $berita['gambar']
        : $base_url . "/uploads/berita/" . $berita['gambar'])
      : $base_url . "/img/default-og.png";
  }
}
?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title><?= $meta_title ?></title>
    <meta name="description" content="<?= $meta_description ?>">
    <link rel="canonical" href="<?= $meta_canonical ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?= $meta_title ?>">
    <meta property="og:description" content="<?= $meta_description ?>">
    <meta property="og:url" content="<?= $meta_canonical ?>">
    <meta property="og:type" content="article">
    <meta property="og:image" content="<?= $og_image ?? '' ?>">
    <meta property="og:site_name" content="Batik Wistara">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= $meta_title ?>">
    <meta name="twitter:description" content="<?= $meta_description ?>">
    <meta name="twitter:image" content="<?= $og_image ?? '' ?>">

      <!-- Fonts -->
    <ink rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&family=Libre+Caslon+Text:ital,wght@0,400;0,700;1,400&display=swap" rel="stylesheet">

    <!-- CSS Bootstrap & Style -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS (wajib di bawah) -->
    <link rel="stylesheet" href="css/style.css">
  </head>
<body>

<?php include 'inc/navbar.php'; ?>
  <!-- Konten Berita -->
  <main class="py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-9">

          <?php if (!isset($berita)): ?>
            <div class="alert alert-danger">Berita tidak ditemukan.</div>
          <?php else: ?>
            <article itemscope itemtype="https://schema.org/NewsArticle">
              <header>
                <h1 class="mb-3" itemprop="headline"><?= htmlspecialchars($berita['judul']) ?></h1>
                <p class="text-muted">
                  <time datetime="<?= $berita['tanggal'] ?>" itemprop="datePublished">
                    <?= date('d F Y', strtotime($berita['tanggal'])) ?>
                  </time>
                </p>
              </header>

              <?php if (!empty($berita['gambar'])): ?>
                <figure class="mb-4">
                  <img src="uploads/berita/<?= $berita['gambar'] ?>" 
                      class="img-fluid rounded" 
                      alt="Gambar Berita" 
                      itemprop="image"
                      style="max-height: 400px; object-fit: cover;" 
                      loading="lazy">
                  <?php if (!empty($berita['sumber'])): ?>
                    <figcaption class="small text-muted mt-2">
                      Sumber: <?= htmlspecialchars($berita['sumber']) ?>
                    </figcaption>
                  <?php endif; ?>
                </figure>
              <?php endif; ?>

              <section class="mb-4 berita-isi" itemprop="articleBody">
                <?= nl2br(htmlspecialchars($berita['isi_berita'])) ?>
              </section>

              <?php if (!empty($berita['tautan_sumber'])): ?>
                <p>
                  Sumber asli: 
                  <a href="<?= $berita['tautan_sumber'] ?>" target="_blank" rel="noopener">
                    <?= $berita['sumber'] ?: $berita['tautan_sumber'] ?>
                  </a>
                </p>
              <?php endif; ?>
            </article>
          <?php endif; ?>

        </div>
      </div>
    </div>
  </main>

<?php include 'inc/footer.php'; ?>