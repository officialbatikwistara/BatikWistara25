<?php include 'config/koneksi.php'; ?>
<?php include 'inc/header.php'; ?>
<?php include 'inc/navbar.php'; ?>

<section>
  <h2>Katalog Produk</h2>
  <div class="produk">
    <?php
    $query = mysqli_query($conn, "SELECT * FROM produk ORDER BY id DESC");
    while ($data = mysqli_fetch_array($query)) {
        echo "
        <div class='card'>
            <img src='img/{$data['gambar']}' alt='{$data['nama_produk']}'>
            <h3>{$data['nama_produk']}</h3>
            <p>Rp " . number_format($data['harga'], 0, ',', '.') . "</p>
        </div>";
    }
    ?>
  </div>
</section>

<?php include 'inc/footer.php'; ?>
