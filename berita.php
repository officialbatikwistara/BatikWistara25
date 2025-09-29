<?php include 'config/koneksi.php'; ?>
<?php include 'inc/header.php'; ?>
<?php include 'inc/navbar.php'; ?>

<section>
  <h2>Berita Terbaru</h2>
  <?php
  $berita = mysqli_query($conn, "SELECT * FROM berita ORDER BY id DESC");
  while ($row = mysqli_fetch_array($berita)) {
      echo "
      <article>
        <h3>{$row['judul']}</h3>
        <img src='img/{$row['gambar']}' alt='{$row['judul']}' width='300'>
        <p>" . substr(strip_tags($row['isi']), 0, 150) . "...</p>
      </article>";
  }
  ?>
</section>

<?php include 'inc/footer.php'; ?>
