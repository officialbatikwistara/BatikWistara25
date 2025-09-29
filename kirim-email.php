<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama  = htmlspecialchars($_POST['nama']);
  $email = htmlspecialchars($_POST['email']);
  $pesan = htmlspecialchars($_POST['pesan']);

  $to      = "official.batikwistara@gmail.com"; // ganti dengan email tujuan
  $subject = "Pesan dari $nama melalui Website Batik Wistara";
  $headers = "From: $email\r\n";
  $headers .= "Reply-To: $email\r\n";
  $headers .= "Content-type: text/plain; charset=UTF-8\r\n";

  $body = "Nama: $nama\nEmail: $email\n\nPesan:\n$pesan";

  if (mail($to, $subject, $body, $headers)) {
    echo "Pesan berhasil dikirim!";
  } else {
    echo "Gagal mengirim pesan. Pastikan server mendukung fungsi mail().";
  }
} else {
  echo "Metode tidak valid.";
}
?>
