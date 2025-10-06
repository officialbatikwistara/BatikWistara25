<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<?php
// Ambil semua data produk dan kategorinya
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
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th>No</th>
          <th>Gambar</th>
          <th>Nama Produk</th>
          <th>Kategori</th>
          <th>Harga</th>
          <th>Tanggal Upload</th>
          <th width="140px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no = 1; while ($p = mysqli_fetch_assoc($produk)) : ?>
          <tr>
            <td class="text-center"><?= $no++ ?></td>
            <td class="text-center">
              <?php if (!empty($p['gambar']) && file_exists("../uploads/produk/" . $p['gambar'])) : ?>
                <img src="../uploads/produk/<?= htmlspecialchars($p['gambar']) ?>" alt="<?= htmlspecialchars($p['nama_produk']) ?>" width="80" class="img-thumbnail">
              <?php else : ?>
                <span class="text-muted">Tidak ada gambar</span>
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($p['nama_produk']) ?></td>
            <td><?= htmlspecialchars($p['nama_kategori']) ?></td>
            <td>Rp <?= number_format($p['harga'], 0, ',', '.') ?></td>
            <td><?= date('d M Y', strtotime($p['tanggal_upload'])) ?></td>
            <td class="text-center">
              <a href="edit_produk.php?id=<?= $p['id_produk'] ?>" class="btn btn-sm btn-warning mb-1">
                <i class="fas fa-edit"></i> Edit
              </a>
              <a href="hapus_produk.php?id=<?= $p['id_produk'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">
                <i class="fas fa-trash-alt"></i> Hapus
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'footer.php'; ?>
