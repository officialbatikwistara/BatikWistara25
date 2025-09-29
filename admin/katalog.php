<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<h2>Daftar Katalog Produk</h2>
<a href="tambah-produk.php" class="btn">+ Tambah Produk</a>

<table>
  <thead>
    <tr>
      <th>Nama Produk</th>
      <th>Kategori</th>
      <th>Harga</th>
      <th>Gambar</th>
      <th>Tanggal</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $query = "SELECT produk.*, kategori_produk.nama_kategori 
              FROM produk 
              LEFT JOIN kategori_produk ON produk.id_kategori = kategori_produk.id_kategori 
              ORDER BY tanggal_upload DESC";
    $data = mysqli_query($conn, $query);
    while ($row = mysqli_fetch_array($data)) {
      echo "<tr>
        <td>{$row['nama_produk']}</td>
        <td>{$row['nama_kategori']}</td>
        <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
        <td><img src='../uploads/produk/{$row['gambar']}' height='60'></td>
        <td>{$row['tanggal_upload']}</td>
      </tr>";
    }
    ?>
  </tbody>
</table>