<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['login'])) {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password=MD5('$password')");
  $cek = mysqli_num_rows($query);

  if ($cek > 0) {
    $_SESSION['admin'] = $username;
    header("Location: dashboard.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<?php include '../inc/header.php'; ?>
<nav class="navbar navbar-expand-lg bg-image-navbar fixed-top">
  <div class="container">

    <!-- Kiri: Logo -->
    <a class="navbar-brand me-auto" href="/index">
      <img src="../img/logowarna.svg" alt="Batik Wistara" height="60">
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

  </div>
</nav>

<div class="login-container">
  <div class="login-box">
    <h2>Login Admin</h2>
    <?php if (isset($error)) echo "<div class='error-msg'>$error</div>"; ?>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
    </form>
  </div>
</div>
