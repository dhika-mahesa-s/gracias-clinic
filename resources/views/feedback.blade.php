<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Kelola Feedback - Gracias Clinic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background-color: #f9f9f9;
    }
    header h1 {
      font-family: 'Playfair Display', serif;
    }
    .feedback-item {
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.08);
      padding: 20px;
      transition: 0.3s;
    }
    .feedback-item.dimmed {
      opacity: 0.6;
      background-color: #f0f0f0;
    }
    .star {
      color: #ddd;
    }
    .star.filled {
      color: #ffc107;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <header class="bg-secondary text-white py-3 px-4 d-flex flex-wrap justify-content-between align-items-center">
    <h1 class="fs-4 mb-0">Gracias Clinic</h1>
    <nav class="nav">
      <a class="nav-link text-white active border-bottom border-white" href="#">Home</a>
      <a class="nav-link text-white" href="#">Our Team</a>
      <a class="nav-link text-white" href="#">Product</a>
      <a class="nav-link text-white" href="#">Promo</a>
      <a class="nav-link text-white" href="#">Contact Us</a>
    </nav>
  </header>

  <!-- Main -->
  <main class="container my-5">
    <div class="bg-white p-4 rounded shadow-sm">
      <h2 class="fw-semibold mb-2">Kelola Feedback</h2>
      <p class="text-muted mb-4">Kelola dan moderasi feedback dari pelanggan</p>

      <!-- Search & Filter -->
      <div class="row g-3 mb-4">
        <div class="col-md-6">
          <input type="text" id="searchInput" class="form-control" placeholder="Cari nama...">
        </div>
        <div class="col-md-3 ms-auto">
          <select id="starFilter" class="form-select">
            <option value="all">Semua</option>
            <option value="5">★★★★★</option>
            <option value="4">★★★★☆</option>
            <option value="3">★★★☆☆</option>
            <option value="2">★★☆☆☆</option>
            <option value="1">★☆☆☆☆</option>
          </select>
        </div>
      </div>

      <!-- Feedback List -->
      <div class="feedback-list">

        <div class="feedback-item mb-4" data-customer="aidhatita" data-rating="4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <h5 class="mb-0 fw-semibold">AidhaTita</h5>
            <button class="btn btn-outline-secondary btn-sm" onclick="toggleFeedback(this)">HIDE</button>
          </div>

          <ul class="list-unstyled mb-3">
            <li>Staf klinik tanggap terhadap kebutuhan saya.</li>
            <li>Dokter/terapis bersikap professional selama perawatan.</li>
            <li>Hasil perawatan sesuai dengan harapan saya.</li>
            <li>Saya ingin kembali melakukan perawatan di klinik ini.</li>
            <li>Secara keseluruhan, saya puas dengan layanan klinik ini.</li>
          </ul>

          <!-- Rating Stars -->
          <div class="border-top pt-3">
            <div class="mb-2">
              <small class="text-muted">Staf klinik tanggap terhadap kebutuhan saya.</small><br>
              <span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star">★</span>
            </div>
            <div class="mb-2">
              <small class="text-muted">Dokter/terapis bersikap professional selama perawatan.</small><br>
              <span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star">★</span>
            </div>
            <div class="mb-2">
              <small class="text-muted">Hasil perawatan sesuai dengan harapan saya.</small><br>
              <span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star">★</span>
            </div>
            <div class="mb-2">
              <small class="text-muted">Saya ingin kembali melakukan perawatan di klinik ini.</small><br>
              <span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star">★</span>
            </div>
            <div class="mb-2">
              <small class="text-muted">Secara keseluruhan, saya puas dengan layanan klinik ini.</small><br>
              <span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star filled">★</span><span class="star">★</span>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

  <footer class="bg-secondary text-white text-center py-4 mt-5">
    <p class="mb-0">&copy; 2025 Gracias Clinic</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function toggleFeedback(button) {
      const feedbackItem = button.closest('.feedback-item');
      feedbackItem.classList.toggle('dimmed');
      button.textContent = button.textContent === 'HIDE' ? 'SHOW' : 'HIDE';
    }

    // Search
    document.getElementById('searchInput').addEventListener('input', function(e) {
      const searchTerm = e.target.value.toLowerCase();
      document.querySelectorAll('.feedback-item').forEach(item => {
        const customer = item.getAttribute('data-customer').toLowerCase();
        item.style.display = customer.includes(searchTerm) ? '' : 'none';
      });
    });

    // Filter
    document.getElementById('starFilter').addEventListener('change', function(e) {
      const selected = e.target.value;
      document.querySelectorAll('.feedback-item').forEach(item => {
        const rating = item.getAttribute('data-rating');
        item.style.display = (selected === 'all' || rating === selected) ? '' : 'none';
      });
    });
  </script>
</body>
</html>
