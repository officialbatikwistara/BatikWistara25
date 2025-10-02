<?php
session_start();
include 'config/koneksi.php';

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

<?php include 'inc/header.php'; ?>
<?php include 'inc/navbar.php'; ?>

<div class="login-container d-flex align-items-center justify-content-center">
  <div class="login-box shadow p-4 rounded">
    <h4 class="text-center mb-3">Login Admin</h4>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST">
      <div class="mb-3">
        <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
      </div>
      <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Password" required>
      </div>
      <div class="d-grid">
        <button type="submit" name="login" class="btn btn-dark">Masuk</button>
      </div>
    </form>
  </div>
</div>

<?php include 'inc/footer.php'; ?>

