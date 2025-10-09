<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">Daftar Berita</h2>
    <a href="tambah-berita.php" class="btn btn-primary">
      <i class="bi bi-plus-circle me-1"></i> Tambah Berita
    </a>
  </div>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-dark text-center">
        <tr>
          <th style="width: 15%;">Judul</th>
          <th style="width: 35%;">Deskripsi</th>
          <th style="width: 10%;">Tanggal</th>
          <th style="width: 20%;">Gambar</th>
          <th style="width: 20%;">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $data = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC");
        while ($row = mysqli_fetch_array($data)) :
        ?>
          <tr>
            <!-- Judul -->
            <td><?= htmlspecialchars($row['judul']) ?></td>

            <!-- Deskripsi + Link -->
            <td>
              <?= mb_substr(strip_tags($row['deskripsi']), 0, 100) ?>...
              <br>
              <?php if (!empty($row['tautan_sumber'])): ?>
                <a href="<?= $row['tautan_sumber'] ?>" target="_blank">Baca Selengkapnya di <?= htmlspecialchars($row['sumber']) ?></a>
              <?php else: ?>
                <a href="berita-detail.php?id=<?= $row['id_berita'] ?>">Baca Selengkapnya</a>
              <?php endif; ?>
            </td>

            <!-- Tanggal -->
            <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>

            <!-- Gambar -->
            <td class="text-center">
              <?php
              $imgSrc = filter_var($row['gambar'], FILTER_VALIDATE_URL)
                ? $row['gambar']
                : "../uploads/berita/{$row['gambar']}";
              ?>
              <img src="<?= $imgSrc ?>" alt="Gambar Berita" class="img-fluid rounded shadow-sm" style="height: 60px; object-fit: cover;">
            </td>

            <!-- Aksi -->
            <td class="text-center">
              <a href="edit-berita.php?id=<?= $row['id_berita'] ?>" class="btn btn-sm btn-warning me-1">
                <i class="bi bi-pencil-square"></i> Edit
              </a>
              <a href="hapus-berita.php?id=<?= $row['id_berita'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                <i class="bi bi-trash"></i> Hapus
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'footer.php'; ?>