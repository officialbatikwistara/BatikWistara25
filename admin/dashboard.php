<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="container py-5">
  <div class="page-head<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="container py-5">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-newspaper me-2"></i>Daftar Berita</h2>
        <a href="tambah-berita.php" class="btn btn-add shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Berita
        </a>
    </div>

    <div class="news-card-container">
        <?php
        $data = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC");
        while ($row = mysqli_fetch_array($data)) :
        ?>
            <div class="news-card shadow-sm">
                <div class="row g-0">
                    <div class="col-md-4">
                        <?php
                        $imgSrc = filter_var($row['gambar'], FILTER_VALIDATE_URL)
                            ? $row['gambar']
                            : "../uploads/berita/{$row['gambar']}";
                        ?>
                        <img src="<?= $imgSrc ?>" class="card-img" alt="Gambar Berita">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body d-flex flex-column h-100">
                            <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                            <small class="card-date mb-2"><i class="bi bi-calendar me-1"></i><?= date('d-m-Y', strtotime($row['tanggal'])) ?></small>
                            <p class="card-text flex-grow-1"><?= mb_substr(strip_tags($row['deskripsi']), 0, 150) ?>...</p>
                            <div class="card-actions mt-auto">
                                <a href="edit-berita.php?id=<?= $row['id_berita'] ?>" class="btn-action btn-edit me-2">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                                <a href="hapus-berita.php?id=<?= $row['id_berita'] ?>" class="btn-action btn-delete" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>er">
    <h2><i class="bi bi-newspaper"></i> Daftar Berita</h2>
    <a href="tambah-berita.php" class="btn btn-add shadow-sm">
      <i class="bi bi-plus-circle me-1"></i> Tambah Berita
    </a>
  </div>

  <div class="table-container">
    <div class="table-responsive">
      <table class="table align-middle modern-table">
        <thead>
          <tr>
            <th>Judul</th>
            <th>Deskripsi</th>
            <th>Tanggal</th>
            <th>Gambar</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $data = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC");
          while ($row = mysqli_fetch_array($data)) :
          ?>
            <tr>
              <td class="fw-semibold"><?= htmlspecialchars($row['judul']) ?></td>
              <td class="text-start">
                <?= mb_substr(strip_tags($row['deskripsi']), 0, 120) ?>...
                <br>
                <?php if (!empty($row['tautan_sumber'])): ?>
                  <a href="<?= $row['tautan_sumber'] ?>" target="_blank" class="text-decoration-none text-primary">
                    <i class="bi bi-box-arrow-up-right"></i> Baca Selengkapnya
                  </a>
                <?php else: ?>
                  <a href="berita-detail.php?id=<?= $row['id_berita'] ?>" class="text-decoration-none text-primary">
                    <i class="bi bi-arrow-right-circle"></i> Baca Selengkapnya
                  </a>
                <?php endif; ?>
              </td>
              <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>
              <td>
                <?php
                $imgSrc = filter_var($row['gambar'], FILTER_VALIDATE_URL)
                  ? $row['gambar']
                  : "../uploads/berita/{$row['gambar']}";
                ?>
                <img src="<?= $imgSrc ?>" alt="Gambar Berita" class="img-thumbnail berita-img">
              </td>
              <td>
                <a href="edit-berita.php?id=<?= $row['id_berita'] ?>" class="btn-action btn-edit me-1">
                  <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="hapus-berita.php?id=<?= $row['id_berita'] ?>" class="btn-action btn-delete" onclick="return confirm('Yakin ingin menghapus berita ini?')">
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

<?php include 'footer.php'; ?>