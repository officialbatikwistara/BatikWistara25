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
    header("Location: admin/dashboard.php");
    exit;
  } else {
    $error = "Username atau password salah!";
  }
}
?>

<?php include 'inc/header.php'; ?>
<?php include 'inc/navbar.php'; ?>

<div class="login-container">
  <div class="login-box shadow p-4 rounded">
    <h4>Login Admin</h4>

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

<style>
/* ==========================
LOGIN PAGE (Booksaw Enhanced)
========================== */
.login-container {
  background-image: url('/img/bg-section2.png');
  background-color: #f5f0e6; /* krem lembut */
  background-size: cover;
  background-position: center;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 180px); /* biar tidak tabrakan dengan header/footer */
  padding: 60px 20px;
}

/* Kotak login */
.login-box {
  background: #ffffff;
  width: 100%;
  max-width: 550px; /* lebar diperbesar */
  padding: 60px 50px;
  border-radius: 20px;
  box-shadow: 0 20px 40px rgba(0, 0, 0, 0.08);
  border-top: 6px solid #ac7b32;
  transition: all 0.3s ease;
  animation: fadeInUp 0.6s ease-out;
}

.login-box:hover {
  transform: translateY(-4px);
}

/* Judul */
.login-box h4 {
  font-family: 'Playfair Display', serif;
  font-size: 32px;
  font-weight: 700;
  color: #1a2247;
  text-align: center;
  margin-bottom: 35px;
}

/* Input fields */
.login-box .form-control {
  font-size: 17px;
  padding: 14px 18px;
  border-radius: 10px;
  border: 1px solid #d4cbb7;
  background-color: #fdfcf9;
  transition: all 0.25s ease;
}

.login-box .form-control:focus {
  border-color: #ac7b32;
  box-shadow: 0 0 8px rgba(172, 123, 50, 0.3);
}

/* Tombol */
.login-box .btn-dark {
  width: 100%;
  padding: 14px;
  font-size: 18px;
  font-weight: 600;
  border-radius: 10px;
  background-color: #ac7b32;
  border: none;
  transition: all 0.3s ease;
}

.login-box .btn-dark:hover {
  background-color: #1a2247;
  transform: translateY(-2px);
}

/* Pesan error */
.alert-danger {
  background-color: #fff3f3;
  border-left: 4px solid #ac7b32;
  color: #a80000;
  font-size: 15px;
  padding: 12px 15px;
  border-radius: 8px;
}

/* Animasi fade-in lembut */
@keyframes fadeInUp {
  from {
    opacity: 0;
    transform: translateY(30px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
</style>

<?php include 'inc/footer.php'; ?>