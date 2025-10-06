<!-- ✅ Navbar Admin -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container-fluid">
    <!-- Logo / Brand -->
    <a class="navbar-brand fw-bold" href="#">Admin Panel</a>

    <!-- Hamburger Toggle -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Menu -->
    <div class="collapse navbar-collapse" id="navbarAdmin">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>" href="dashboard.php">
            <i class="bi bi-newspaper me-1"></i> Berita
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'katalog.php' ? 'active' : '' ?>" href="katalog.php">
            <i class="bi bi-tags me-1"></i> Katalog
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'kategori.php' ? 'active' : '' ?>" href="kategori.php">
            <i class="bi bi-folder me-1"></i> Kategori
          </a>
        </li>
      </ul>

      <!-- Kanan: Logout -->
      <div class="d-flex align-items-center">
        <span class="text-white me-3 small">Halo, Admin</span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">
          <i class="bi bi-box-arrow-right"></i> Logout
        </a>
      </div>
    </div>
  </div>
</nav>
