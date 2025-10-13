<?php include 'header.php'; ?>
<?php include 'navbar.php'; ?>
<?php include '../config/koneksi.php'; ?>

<div class="container py-5">
    <div class="page-header d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-newspaper me-2"></i> Daftar Berita</h2>
        <a href="tambah-berita.php" class="btn btn-add shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Tambah Berita
        </a>
    </div>

    <div class="table-container shadow-lg">
        <div class="table-responsive">
            <table class="table modern-table">
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
                            <td class="fw-semibold text-start"><?= htmlspecialchars($row['judul']) ?></td>
                            <td class="text-start">
                                <?= mb_substr(strip_tags($row['deskripsi']), 0, 150) ?>...
                                <br>
                                <?php if (!empty($row['tautan_sumber'])) : ?>
                                    <a href="<?= $row['tautan_sumber'] ?>" target="_blank" class="read-more-link">
                                        <i class="bi bi-box-arrow-up-right"></i> Baca Selengkapnya
                                    </a>
                                <?php else : ?>
                                    <a href="berita-detail.php?id=<?= $row['id_berita'] ?>" class="read-more-link">
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
                            <td class="action-buttons">
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