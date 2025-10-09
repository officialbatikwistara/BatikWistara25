<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<main class="admin-page">
  <div class="admin-container">
    <!-- Header -->
    <div class="admin-header">
      <h2>Daftar Berita</h2>
      <a href="tambah-berita.php" class="btn-add">
        <i class="bi bi-plus-circle me-1"></i> Tambah Berita
      </a>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
      <table class="table-booksaw">
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
              <td><?= htmlspecialchars($row['judul']) ?></td>

              <td>
                <?= mb_substr(strip_tags($row['deskripsi']), 0, 100) ?>...
                <br>
                <?php if (!empty($row['tautan_sumber'])): ?>
                  <a href="<?= $row['tautan_sumber'] ?>" target="_blank" class="link-more">
                    Baca Selengkapnya di <?= htmlspecialchars($row['sumber']) ?>
                  </a>
                <?php else: ?>
                  <a href="berita-detail.php?id=<?= $row['id_berita'] ?>" class="link-more">Baca Selengkapnya</a>
                <?php endif; ?>
              </td>

              <td><?= date('d-m-Y', strtotime($row['tanggal'])) ?></td>

              <td class="text-center">
                <?php
                $imgSrc = filter_var($row['gambar'], FILTER_VALIDATE_URL)
                  ? $row['gambar']
                  : "../uploads/berita/{$row['gambar']}";
                ?>
                <img src="<?= $imgSrc ?>" alt="Gambar Berita" class="img-thumb">
              </td>

              <td class="text-center">
                <a href="edit-berita.php?id=<?= $row['id_berita'] ?>" class="btn-action btn-edit">
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
</main>

<?php include 'footer.php'; ?>
