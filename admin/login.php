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
<?php include '../inc/navbar.php'; ?>


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

<?php include '../inc/footer.php'; ?>