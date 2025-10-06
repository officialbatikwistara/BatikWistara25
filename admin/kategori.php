<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<?php
$kategori = mysqli_query($conn, "SELECT * FROM kategori_produk ORDER BY id_kategori ASC");
?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Daftar Kategori</h3>
    <a href="tambah_kategori.php" class="btn btn-primary">+ Tambah Kategori</a>
  </div>

  <table class="table table-bordered table-striped">
    <thead class="table-dark text-center">
      <tr>
        <th>No</th>
        <th>Nama Kategori</th>
      </tr>
    </thead>
    <tbody>
      <?php $no = 1; while ($k = mysqli_fetch_assoc($kategori)) : ?>
        <tr>
          <td class="text-center"><?= $no++ ?></td>
          <td><?= htmlspecialchars($k['nama_kategori']) ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>
