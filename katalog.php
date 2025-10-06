<?php
include 'config/koneksi.php';
include 'inc/header.php';
include 'inc/navbar.php';

// Ambil kategori
$kategori = mysqli_query($conn, "SELECT * FROM kategori_produk");

// Ambil filter kategori
$filter = $_GET['kategori'] ?? 'all';
if ($filter === 'all') {
  $produk = mysqli_query($conn, "SELECT produk.*, kategori_produk.nama_kategori 
    FROM produk 
    JOIN kategori_produk ON produk.id_kategori = kategori_produk.id_kategori 
    ORDER BY tanggal_upload DESC");
} else {
  $filter = intval($filter);
  $produk = mysqli_query($conn, "SELECT produk.*, kategori_produk.nama_kategori 
    FROM produk 
    JOIN kategori_produk ON produk.id_kategori = kategori_produk.id_kategori 
    WHERE kategori_produk.id_kategori = $filter 
    ORDER BY tanggal_upload DESC");
}
?>

<section class="section-katalog py-5 bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-4">Katalog Produk</h2>
    <hr class="mb-4" style="width: 60px; height: 3px; background-color: #CDA349; margin: 0 auto;">

    <!-- Filter Kategori -->
    <div class="text-center mb-5">
      <a href="katalog?kategori=all" class="btn btn-outline-dark m-1 <?= ($filter === 'all') ? 'active' : '' ?>">Semua</a>
      <?php while ($k = mysqli_fetch_assoc($kategori)) : ?>
        <a href="katalog?kategori=<?= $k['id_kategori'] ?>" class="btn btn-outline-dark m-1 <?= ($filter == $k['id_kategori']) ? 'active' : '' ?>">
          <?= htmlspecialchars($k['nama_kategori']) ?>
        </a>
      <?php endwhile; ?>
    </div>

    <!-- Daftar Produk -->
    <div class="row row-cols-1 row-cols-md-3 g-4">
      <?php while ($p = mysqli_fetch_assoc($produk)) : ?>
        <div class="col">
          <div class="card h-100 shadow-sm">
            <img src="uploads/produk/<?= htmlspecialchars($p['gambar']) ?>" class="card-img-top" alt="<?= htmlspecialchars($p['nama_produk']) ?>">
            <div class="card-body">
              <h5 class="card-title fw-bold"><?= htmlspecialchars($p['nama_produk']) ?></h5>
              <p class="badge bg-secondary"><?= htmlspecialchars($p['nama_kategori']) ?></p>
              <p class="card-text text-muted"><?= htmlspecialchars(substr($p['deskripsi'], 0, 80)) ?>...</p>
              <!--<p class="text-primary fw-bold">Rp <?= number_format($p['harga'], 0, ',', '.') ?>-->
              <p class="text-muted"><small>Diunggah: <?= date('d M Y', strtotime($p['tanggal_upload'])) ?></small></p>
              <button type="button" class="btn btn-outline-dark w-100" data-bs-toggle="modal" data-bs-target="#modalProduk<?= $p['id_produk'] ?>">
                Beli Sekarang
              </button>
            </div>
          </div>
        </div>

        <!-- Modal Produk -->
        <div class="modal fade" id="modalProduk<?= $p['id_produk'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $p['id_produk'] ?>" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="modalLabel<?= $p['id_produk'] ?>">Detail Produk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
              </div>
              <div class="modal-body">
                <div class="row g-4">
                  <div class="col-md-5 text-center">
                    <img src="uploads/produk/<?= htmlspecialchars($p['gambar']) ?>" class="img-fluid rounded shadow" alt="<?= $p['nama_produk'] ?>">
                  </div>
                  <div class="col-md-7">
                    <h4 class="fw-bold"><?= htmlspecialchars($p['nama_produk']) ?></h4>
                    <p class="badge bg-secondary mb-2"><?= htmlspecialchars($p['nama_kategori']) ?></p>
                    <p class="text-muted"><small>Diunggah: <?= date('d M Y', strtotime($p['tanggal_upload'])) ?></small></p>
                    <p><?= nl2br(htmlspecialchars($p['deskripsi'])) ?></p>
                    <!--<p class="fw-bold text-primary fs-5">Rp <?= number_format($p['harga'], 0, ',', '.') ?></p>-->
                    
                    <hr>
                    <p><strong>Beli melalui:</strong></p>
                    <div class="d-flex flex-column gap-2">
                      <!-- Tombol Aksi -->
                      <?php
                      $pesan = "Halo admin wistara, saya ingin bertanya mengenai produk " . $p['nama_produk'];
                      $link_wa = "https://wa.me/62895381110035?text=" . urlencode($pesan);
                      ?>

                      <div class="d-grid gap-2">
                        <a href="<?= $link_wa ?>" target="_blank" class="btn btn-outline-dark w-100 d-flex align-items-center justify-content-center gap-2">
                          <i class="fab fa-whatsapp fa-lg text-success"></i> <span>WhatsApp</span>
                        </a>

                        <a href="<?= htmlspecialchars($p['link_shopee']) ?: '#' ?>" target="_blank" class="btn btn-outline-dark w-100 d-flex align-items-center justify-content-center gap-2">
                          <i class="fas fa-store fa-lg text-warning"></i> <span>Shopee</span>
                        </a>

                        <a href="<?= htmlspecialchars($p['link_tiktok']) ?: '#' ?>" target="_blank" class="btn btn-outline-dark w-100 d-flex align-items-center justify-content-center gap-2">
                          <i class="fab fa-tiktok fa-lg text-dark"></i> <span>TikTokShop</span>
                        </a>

                        <a href="checkout.php?id=<?= $p['id_produk'] ?>" class="btn btn-outline-dark w-100 d-flex align-items-center justify-content-center gap-2">
                          <i class="fas fa-shopping-cart fa-lg text-primary"></i> <span>Website</span>
                        </a>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<?php include 'inc/footer.php'; ?>
