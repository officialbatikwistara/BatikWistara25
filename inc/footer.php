<footer class="bg-light text-dark pt-4 pb-3 mt-5 shadow-sm">
  <div class="container">
    <div class="row text-center text-md-start align-items-start g-8">

      <!-- Kolom 1 -->
      <div class="col-md-5 mb-4">
        <!-- Logo -->
        <div class="mb-3">
          <img src="./img/logowarna.svg" alt="Batik Wistara" height="80">
        </div>

        <!-- Deskripsi -->
        <p style="max-width: 90%;">
          <strong>Batik Wistara</strong> adalah wujud cinta terhadap warisan budaya Indonesia. Dibuat dengan tangan yang terampil.
        </p>
      </div>

      <!-- Kolom 2 -->
      <div class="col-md-3 mb-4">
        <h5 class="fw-bold mb-3">Navigasi</h5>
        <ul class="list-unstyled">
          <li><a href="/index" class="text-dark text-decoration-none">Beranda</a></li>
          <li><a href="/about" class="text-dark text-decoration-none">Tentang</a></li>
          <li><a href="/katalog" class="text-dark text-decoration-none">Katalog</a></li>
          <li><a href="/berita" class="text-dark text-decoration-none">Berita</a></li>
        </ul>
      </div>

      <!-- Kolom 3 -->
      <div class="col-md-4 mb-4">
        <h5 class="fw-bold mb-3">Kontak Kami</h5>
        <div class="d-flex">
          <div class="me-3" style="min-width: 80px;">Alamat</div>
          <div>: <a href="https://maps.app.goo.gl/WqHPo5eNBDqHykhM8" class="text-dark text-decoration-none">Jl. Tambak Medokan Ayu VI C No.56B, Medokan Ayu, 
            Kec. Rungkut, Surabaya, Jawa Timur 60295</a></div>
        </div>
        <div class="d-flex">
          <div class="me-3" style="min-width: 80px;">WhatsApp</div>
          <div>: <a href="https://wa.me/6281234567890" class="text-dark text-decoration-none">0812-3456-7890</a></div>
        </div>
        <!-- Email Link -->
        <div class="d-flex">
          <div class="me-3" style="min-width: 80px;">Email</div>
          <div>
            : <a href="#" onclick="openEmailPopup()" class="text-dark text-decoration-none">official.batikwistara@gmail.com</a>
          </div>
        </div>

        <!-- Modal Pop-up Kirim Pesan -->
        <div id="emailPopup" class="email-popup">
          <div class="email-popup-content">
            <span class="email-popup-close" onclick="closeEmailPopup()">&times;</span>
            <h3>Kirim Pesan ke Batik Wistara</h3>
            <form id="popupEmailForm" onsubmit="submitPopupForm(event)">
              <input type="text" id="popupNama" placeholder="Nama Anda" required>
              <input type="email" id="popupEmail" placeholder="Email Anda" required>
              <textarea id="popupPesan" placeholder="Pesan Anda" rows="4" required></textarea>
              <button type="submit">Kirim</button>
            </form>
          </div>
        </div>

      </div>

    </div>


    <hr class="border-top border-secondary my-3">

    <div class="text-center small">
      &copy; <?= date('Y') ?> Batik Wistara. Seluruh hak cipta dilindungi.
    </div>
  </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openEmailPopup() {
  document.getElementById('emailPopup').style.display = 'block';
}

function closeEmailPopup() {
  document.getElementById('emailPopup').style.display = 'none';
}

function submitPopupForm(e) {
  e.preventDefault();

  const nama  = document.getElementById('popupNama').value;
  const email = document.getElementById('popupEmail').value;
  const pesan = document.getElementById('popupPesan').value;

  const formData = new FormData();
  formData.append('nama', nama);
  formData.append('email', email);
  formData.append('pesan', pesan);

  fetch('kirim-email.php', {
    method: 'POST',
    body: formData
  })
  .then(res => res.text())
  .then(data => {
    alert(data); // tampilkan respon dari PHP
    document.getElementById('popupEmailForm').reset();
    closeEmailPopup();
  })
  .catch(err => {
    alert('Terjadi kesalahan saat mengirim pesan.');
    console.error(err);
  });
}
</script>
<script>
  window.addEventListener("load", function () {
    const navbar = document.querySelector(".navbar");
    const navbarHeight = navbar.offsetHeight;
    document.body.style.paddingTop = navbarHeight + "px";
  });
</script>


</body>