<?php
if (!function_exists('asset')) {
  $https  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || 
            (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);
  $scheme = $https ? 'https' : 'http';
  $basePath = trim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
  $basePath = $basePath ? '/' . $basePath : '';
  define('BASE_URL', $scheme . '://' . $_SERVER['HTTP_HOST'] . $basePath . '/');
  
  function asset($path) {
    return BASE_URL . ltrim($path, '/');
  }
}
?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<footer class="bg-light text-dark pt-5 pb-4 shadow-sm">
  <div class="container">
    <div class="row text-center text-md-start align-items-start gy-4 gx-5">

      <!-- Logo & Deskripsi -->
      <div class="col-md-5">
        <div class="mb-3">
          <img src="<?= asset('img/logowarna.svg') ?>" alt="Batik Wistara" height="80">
        </div>
        <p style="max-width: 90%;">
          <strong>Batik Wistara</strong> adalah wujud cinta terhadap warisan budaya Indonesia. Dibuat dengan tangan yang terampil dan penuh cinta.
        </p>
      </div>

      <!-- Navigasi -->
      <div class="col-md-3">
        <h5 class="fw-bold mb-3">Navigasi</h5>
        <ul class="list-unstyled">
          <li><a href="<?= BASE_URL ?>index" class="text-dark text-decoration-none">Beranda</a></li>
          <li><a href="<?= BASE_URL ?>about" class="text-dark text-decoration-none">Tentang</a></li>
          <li><a href="<?= BASE_URL ?>katalog" class="text-dark text-decoration-none">Katalog</a></li>
          <li><a href="<?= BASE_URL ?>berita" class="text-dark text-decoration-none">Berita</a></li>
        </ul>
      </div>

      <!-- Kontak -->
      <div class="col-md-4">
        <h5 class="fw-bold mb-3">Kontak Kami</h5>
        <ul class="list-unstyled">
          <li class="mb-2">
            <strong>Alamat:</strong><br>
            <a href="https://maps.app.goo.gl/WqHPo5eNBDqHykhM8" target="_blank" class="text-dark text-decoration-none">
              Jl. Tambak Medokan Ayu VI C No.56B, Surabaya, Jawa Timur 60295
            </a>
          </li>
          <li class="mb-2">
            <strong>WhatsApp:</strong><br>
            <a href="https://wa.me/6281234567890" class="text-dark text-decoration-none">0812-3456-7890</a>
          </li>
          <li>
            <strong>Email:</strong><br>
            <a href="#" onclick="openEmailPopup()" class="text-dark text-decoration-none">official.batikwistara@gmail.com</a>
          </li>
        </ul>
      </div>

    </div>

    <hr class="border-top border-secondary my-4">

    <div class="text-center small">
      &copy; <?= date('Y') ?> Batik Wistara. Seluruh hak cipta dilindungi.
    </div>
  </div>
</footer>

