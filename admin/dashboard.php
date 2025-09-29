<?php include 'header.php'; ?>
<?php include '../config/koneksi.php'; ?>

<h2>Daftar Berita</h2>
<a href="tambah-berita.php" class="btn">+ Tambah Berita</a>

<table>
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
    while ($row = mysqli_fetch_array($data)) {
      echo "<tr>";

      // Kolom Judul
      echo "<td>{$row['judul']}</td>";

      // Kolom Deskripsi + Link "Baca Selengkapnya"
      echo "<td>";
      echo $row['deskripsi'] . "<br>";

      // Link ke detail internal atau sumber eksternal
      if (!empty($row['tautan_sumber'])) {
        echo "<a href='{$row['tautan_sumber']}' target='_blank'>Baca Selengkapnya di {$row['sumber']}</a>";
      } else {
        echo "<a href='berita-detail.php?id={$row['id_berita']}'>Baca Selengkapnya</a>";
      }
      echo "</td>";

      // Kolom Tanggal
      echo "<td>{$row['tanggal']}</td>";

      // Kolom Gambar
      echo "<td>";
      if (filter_var($row['gambar'], FILTER_VALIDATE_URL)) {
        // Jika gambar adalah link
        echo "<img src='{$row['gambar']}' height='60'>";
      } else {
        // Jika gambar adalah file lokal
        echo "<img src='../uploads/berita/{$row['gambar']}' height='60'>";
      }
      echo "</td>";

      // Kolom Aksi
      echo "<td>
        <a href='edit-berita.php?id={$row['id_berita']}' class='btn'>Edit</a>
        <a href='hapus-berita.php?id={$row['id_berita']}' class='btn' style='background:crimson;' onclick=\"return confirm('Yakin ingin menghapus berita ini?')\">Hapus</a>
      </td>";

      echo "</tr>";
    }
    ?>
  </tbody>
</table>
