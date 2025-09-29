<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit;
}
?>
<?php include 'inc/header.php'; ?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
</head>
<body>
  <h1>Selamat datang, <?= $_SESSION['admin'] ?>!</h1>
  <p><a href="logout.php">Logout</a></p>
</body>
</html>
