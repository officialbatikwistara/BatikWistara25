<?php
include '../config/koneksi.php';
include 'header.php'; // Header admin

// Ambil semua data produk + nama kategori
$produk = mysqli_query($conn, "SELECT produk.*, kategori_produk.nama_kategori 
  FROM produk 
  JOIN kategori_produk ON produk.id_kategori = kategori_produk.id_kategori 
  ORDER BY tanggal_upload DESC");
?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="fw-bold">Kelola Katalog Produk</h3>
    <a href="tambah_produk.php" class="btn btn-primary">+ Tambah Produk</a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead class="table-dark text-center">
        <tr>
          <th>No</th>
          <th>Gambar</th>
          <th>Nama Produk</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Tanggal Upload</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($p = mysqli_fetch_assoc($produk)) :
        ?>
          <tr class="align-middle">
            <td class="text-center"><?= $no++ ?></td>
            <td class="text-center">
              <img src="../uploads/produk/<?= htmlspecialchars($p['gambar']) ?>" alt="<?= $p['nama_produk'] ?>" width="80">
            </td>
            <td><?= htmlspecialchars($p['nama_produk']) ?></td>
            <td><?= htmlspecialchars($p['nama_kategori']) ?></td>
            <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
            <td><?= date('d M Y', strtotime($p['tanggal_upload'])) ?></td>
            <td class="text-center">
              <a href="edit_produk.php?id=<?= $p['id_produk'] ?>" class="btn btn-sm btn-warning">Edit</a>
              <a href="hapus_produk.php?id=<?= $p['id_produk'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
