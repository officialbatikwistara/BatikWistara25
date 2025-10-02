<?php
include 'config/koneksi.php';

// Ambil parameter pencarian & limit
$search = $_GET['search'] ?? '';
$limit = isset($_GET['limit']) && is_numeric($_GET['limit']) ? (int) $_GET['limit'] : 4;
$page  = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query pencarian
$whereClause = '';
if (!empty($search)) {
  $search = mysqli_real_escape_string($conn, $search);
  $whereClause = "WHERE judul LIKE '%$search%' OR deskripsi LIKE '%$search%'";
}

// Hitung total data untuk pagination
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM berita $whereClause");
$totalRow = mysqli_fetch_assoc($totalQuery);
$total = $totalRow['total'];
$total_pages = ceil($total / $limit);

// Ambil data berita
$query = mysqli_query($conn, "SELECT * FROM berita $whereClause ORDER BY tanggal DESC LIMIT $limit OFFSET $offset");
?>

<?php include 'inc/header.php'; ?>
<?php include 'inc/navbar.php'; ?>

<section class="section-berita py-5 bg-light">
  <div class="container">

    <!-- Judul -->
    <h2 class="text-center text-dark mb-2">Berita Terkini</h2>
    <p class="text-center text-muted mb-4">Lihat informasi dan kegiatan terbaru dari Batik Wistara</p>
    <hr class="w-25 mx-auto mb-4">

    <!-- Filter -->
    <form method="GET" class="row align-items-center justify-content-center g-2 mb-5">
      <div class="col-md-5">
        <input type="text" name="search" class="form-control" placeholder="Cari berita..." value="<?= htmlspecialchars($search) ?>">
      </div>
      <div class="col-auto">
        <select name="limit" class="form-select" onchange="this.form.submit()">
          <option value="8" <?= $limit == 8 ? 'selected' : '' ?>>8</option>
          <option value="20" <?= $limit == 20 ? 'selected' : '' ?>>20</option>
          <option value="50" <?= $limit == 50 ? 'selected' : '' ?>>50</option>
        </select>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-dark">Cari</button>
      </div>
    </form>

    <!-- Grid Card -->
    <div class="row g-4">
      <?php if (mysqli_num_rows($query) > 0): ?>
        <?php while ($b = mysqli_fetch_array($query)) :
          $gambar = filter_var($b['gambar'], FILTER_VALIDATE_URL)
            ? $b['gambar']
            : (function_exists('asset') ? asset('uploads/berita/' . $b['gambar']) : 'uploads/berita/' . $b['gambar']);
        ?>
          <div class="col-md-6 col-lg-3">
            <div class="card h-100 shadow-sm border-0 berita-card">
              <div class="position-relative">
                <img src="<?= $gambar ?>" class="card-img-top" alt="<?= htmlspecialchars($b['judul']) ?>" style="height: 220px; object-fit: cover;">
                <?php if (!empty($b['sumber'])): ?>
                  <small class="position-absolute bottom-0 end-0 m-2 bg-white bg-opacity-75 px-2 py-1 rounded text-muted">
                    Sumber: <?= htmlspecialchars($b['sumber']) ?>
                  </small>
                <?php endif; ?>
              </div>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title"><?= htmlspecialchars($b['judul']) ?></h5>
                <p class="card-text small text-muted mb-2"><?= date('d F Y', strtotime($b['tanggal'])) ?></p>
                <p class="card-text flex-grow-1"><?= mb_substr(strip_tags($b['deskripsi']), 0, 120) ?>...</p>
                <?php if (!empty($b['tautan_sumber'])): ?>
                    <a href="<?= $b['tautan_sumber'] ?>" target="_blank" class="berita-link">Baca Selengkapnya →</a>
                  <?php else: ?>
                    <a href="/berita/<?= $b['slug'] ?>" class="berita-link">Baca Selengkapnya →</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-12 text-center">
          <div class="alert alert-warning">Berita tidak ditemukan.</div>
        </div>
      <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
      <nav class="mt-5" aria-label="Navigasi halaman berita">
        <ul class="pagination justify-content-center">
          <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= max(1, $page - 1) ?>&limit=<?= $limit ?>&search=<?= urlencode($search) ?>">‹</a>
          </li>
          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
              <a class="page-link" href="?page=<?= $i ?>&limit=<?= $limit ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
            </li>
          <?php endfor; ?>
          <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= min($total_pages, $page + 1) ?>&limit=<?= $limit ?>&search=<?= urlencode($search) ?>">›</a>
          </li>
        </ul>
      </nav>
    <?php endif; ?>

  </div>
</section>

<?php include 'inc/footer.php'; ?>
