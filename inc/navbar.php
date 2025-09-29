<nav class="navbar navbar-expand-lg bg-image-navbar">
  <div class="container">

    <!-- Logo di pojok kiri -->
    <a class="navbar-brand" href="/index">
      <img src="./img/logowarna.svg" alt="Batik Wistara" height="60">
    </a>

    <!-- Toggler muncul di kanan saat mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu navigasi rata tengah -->
    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
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

      <!-- Logo Login Admin di pojok kanan -->
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/admin/login.php" title="Login Admin">
            <img src="./img/admin-icon.png" alt="Admin" height="32">
          </a>
        </li>
      </ul>
    </div>

  </div>
</nav>
