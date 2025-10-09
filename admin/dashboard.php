<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="container py-5">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold text-dark mb-0">📰 Daftar Berita</h2>
    <a href="tambah-berita.php" class="btn btn-primary shadow-sm px-3 py-2">
      <i class="bi bi-plus-circle me-1"></i> Tambah Berita
    </a>
  </div>

  <div class="card border-0 shadow-sm rounded-4">
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-hover align-middle mb-0 table-modern text-nowrap">
          <thead class="bg-dark text-white text-center">
            <tr>
              <th scope="col" style="width: 18%;">Judul</th>
              <th scope="col" style="width: 40%;">Deskripsi</th>
              <th scope="col" style="width: 10%;">Tanggal</th>
              <th scope="col" style="width: 15%;">Gambar</th>
              <th scope="col" style="width: 17%;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $data = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC");
            while ($row = mysqli_fetch_array($data)) :
            ?>
              <tr>
                <td class="fw-semibold"><?= htmlspecialchars($row['judul']) ?></td>
                <td>
                  <?= mb_substr(strip_tags($row['deskripsi']), 0, 100) ?>...
                  <br>
                  <?php if (!empty($row['tautan_sumber'])): ?>
                    <a href="<?= $row['tautan_sumber'] ?>" target="_blank" class="link-baca">Baca Selengkapnya di <?= htmlspecialchars($row['sumber']) ?></a>
                  <?php else: ?>
                    <a href="berita-detail.php?id=<?= $row['id_berita'] ?>" class="link-baca">Baca Selengkapnya</a>
                  <?php endif; ?>
                </td>
                <td class="text-center text-muted">
                  <?= date('d-m-Y', strtotime($row['tanggal'])) ?>
                </td>
                <td class="text-center">
                  <?php
                  $imgSrc = filter_var($row['gambar'], FILTER_VALIDATE_URL)
                    ? $row['gambar']
                    : "../uploads/berita/{$row['gambar']}";
                  ?>
                  <img src="<?= $imgSrc ?>" alt="Gambar Berita" class="img-thumbnail shadow-sm rounded-3" style="width: 100px; height: 70px; object-fit: cover;">
                </td>
                <td class="text-center">
                  <a href="edit-berita.php?id=<?= $row['id_berita'] ?>" class="btn btn-warning btn-sm me-1 shadow-sm text-white">
                    <i class="bi bi-pencil-square"></i> Edit
                  </a>
                  <a href="hapus-berita.php?id=<?= $row['id_berita'] ?>" class="btn btn-danger btn-sm shadow-sm" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                    <i class="bi bi-trash"></i> Hapus
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
