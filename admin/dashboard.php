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

    <div class="news-card-container">
        <?php
        $data = mysqli_query($conn, "SELECT * FROM berita ORDER BY tanggal DESC");
        while ($row = mysqli_fetch_array($data)) :
        ?>
            <div class="news-card shadow-sm">
                <div class="card-image-wrapper">
                    <?php
                    $imgSrc = filter_var($row['gambar'], FILTER_VALIDATE_URL)
                        ? $row['gambar']
                        : "../uploads/berita/{$row['gambar']}";
                    ?>
                    <img src="<?= $imgSrc ?>" class="card-img" alt="Gambar Berita">
                </div>
                <div class="card-content">
                    <h5 class="card-title"><?= htmlspecialchars($row['judul']) ?></h5>
                    <small class="card-date mb-2"><i class="bi bi-calendar me-1"></i><?= date('d-m-Y', strtotime($row['tanggal'])) ?></small>
                    <p class="card-text"><?= mb_substr(strip_tags($row['deskripsi']), 0, 150) ?>...</p>
                    <div class="card-actions">
                        <a href="edit-berita.php?id=<?= $row['id_berita'] ?>" class="btn-action btn-edit me-2">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <a href="hapus-berita.php?id=<?= $row['id_berita'] ?>" class="btn-action btn-delete" onclick="return confirm('Yakin ingin menghapus berita ini?')">
                            <i class="bi bi-trash"></i> Hapus
                        </a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<?php include 'footer.php'; ?>