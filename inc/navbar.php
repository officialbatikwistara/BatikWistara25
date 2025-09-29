<nav class="navbar navbar-expand-lg bg-image-navbar fixed-top">
  <div class="container">

    <!-- Kiri: Logo -->
    <a class="navbar-brand me-auto" href="/index">
      <img src="./img/logowarna.svg" alt="Batik Wistara" height="60">
    </a>

    <!-- Toggler untuk mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Tengah: Menu -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item">
          <a class="nav-link px-4 <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>" href="/index">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-4 <?= basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : '' ?>" href="/about">Tentang</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-4 <?= basename($_SERVER['PHP_SELF']) == 'katalog.php' ? 'active' : '' ?>" href="/katalog">Katalog</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-4 <?= basename($_SERVER['PHP_SELF']) == 'berita.php' ? 'active' : '' ?>" href="/berita">Berita</a>
        </li>
        <li class="nav-item">
          <a class="nav-link px-4 <?= basename($_SERVER['PHP_SELF']) == 'kontak.php' ? 'active' : '' ?>" href="/kontak">Kontak</a>
        </li>
      </ul>
    </div>

    <!-- Kanan: Login Admin -->
    <div class="d-none d-lg-block">
      <a class="nav-link" href="/admin/login.php" title="Login Admin">
        <img src="./img/admin-icon.png" alt="Admin" height="32">
      </a>
    </div>

  </div>
</nav>
