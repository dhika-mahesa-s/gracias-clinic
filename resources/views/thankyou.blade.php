<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Beri Feedback - Gracias Clinic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
  <style>
    body { font-family: 'Poppins', sans-serif; background-color: #f9f9f9; }
    .hero { background: linear-gradient(135deg, #4b5a68 0%, #2e8b8b 100%); color: white; padding: 80px 0; text-align: center; }
    .hero h2 { font-family: 'Playfair Display', serif; font-size: 2.5rem; }
    .star { font-size: 28px; color: #ddd; cursor: pointer; transition: color 0.2s, transform 0.1s; }
    .star.active { color: #ffc107; }
    .star:hover { transform: scale(1.1); }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:#4b5a68;">
    <div class="container">
      <a class="navbar-brand fw-semibold" href="#">Gracias Clinic</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/our-team') }}">Our Team</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/product') }}">Product</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/promo') }}">Promo</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/contact-us') }}">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero -->
  <section class="hero">
    <div class="container">
      <h2>Better Care Starts with Your Words</h2>
      <p class="lead mt-3">Bagikan pengalaman Anda untuk membantu kami terus meningkatkan kualitas layanan</p>
    </div>
  </section>

  <!-- Form -->
  <div class="container mt-n5 mb-5">
    <div class="card shadow-lg border-0 mx-auto" style="max-width: 800px;">
      <div class="card-body p-5">
        <form action="{{ route('feedback.store') }}" method="POST" id="feedbackForm">
          @csrf

          <!-- Informasi Dasar -->
          <div class="mb-3">
            <label for="name" class="form-label fw-semibold">Nama Lengkap *</label>
            <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
          </div>

          <div class="mb-3">
            <label for="email" class="form-label fw-semibold">Email *</label>
            <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label fw-semibold">Nomor Telepon</label>
            <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
          </div>

          <div class="mb-4">
            <label for="service_type" class="form-label fw-semibold">Jenis Layanan yang Diterima</label>
            <select class="form-select" id="service_type" name="service_type">
              <option value="">Pilih Layanan</option>
              <option value="facial" {{ old('service_type') == 'facial' ? 'selected' : '' }}>Facial Treatment</option>
              <option value="laser" {{ old('service_type') == 'laser' ? 'selected' : '' }}>Laser Treatment</option>
              <option value="injection" {{ old('service_type') == 'injection' ? 'selected' : '' }}>Injection</option>
              <option value="konsultasi" {{ old('service_type') == 'konsultasi' ? 'selected' : '' }}>Konsultasi</option>
              <option value="lainnya" {{ old('service_type') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
          </div>

          <!-- Rating -->
          @php
            $questions = [
              'staff_rating' => 'Staf klinik tanggap terhadap kebutuhan saya.',
              'professional_rating' => 'Dokter/terapis bersikap profesional selama perawatan.',
              'result_rating' => 'Hasil perawatan sesuai dengan harapan saya.',
              'return_rating' => 'Saya ingin kembali melakukan perawatan di klinik ini.',
              'overall_rating' => 'Secara keseluruhan, saya puas dengan layanan klinik ini.'
            ];
          @endphp

          @foreach($questions as $name => $text)
          <div class="card mb-3 border-light shadow-sm">
            <div class="card-body">
              <div class="fw-semibold mb-2">{{ $text }}</div>
              <div class="d-flex align-items-center gap-2 rating-stars" data-category="{{ $name }}">
                @for($i = 1; $i <= 5; $i++)
                  <span class="star" data-rating="{{ $i }}">★</span>
                @endfor
              </div>
              <div class="d-flex justify-content-between text-muted small mt-1">
                <span>Tidak Puas</span><span>Sangat Puas</span>
              </div>
              <input type="hidden" name="{{ $name }}" id="{{ $name }}" value="{{ old($name, 0) }}" required>
            </div>
          </div>
          @endforeach

          <!-- Komentar -->
          <div class="mb-4">
            <label for="message" class="form-label fw-semibold">Komentar Tambahan (Opsional)</label>
            <textarea class="form-control" id="message" name="message" rows="4" placeholder="Bagikan pengalaman lengkap Anda...">{{ old('message') }}</textarea>
          </div>

          <!-- Tombol Submit -->
          <div class="text-center">
            <button type="submit" class="btn btn-primary px-4 py-2" style="background: linear-gradient(135deg, #4b5a68 0%, #2e8b8b 100%); border: none;">
              <i class="fas fa-paper-plane me-2"></i>Kirim Feedback
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="bg-dark mt-5" style="height:100px; clip-path: ellipse(100% 100% at 50% 100%);"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      initializeStarRatings();

      document.getElementById('feedbackForm').addEventListener('submit', function(e) {
        const requiredRatings = ['staff_rating','professional_rating','result_rating','return_rating','overall_rating'];
        let allRated = true;
        requiredRatings.forEach(id => {
          const val = document.getElementById(id).value;
          if (val === '0' || val === '') allRated = false;
        });
        if (!allRated) {
          e.preventDefault();
          alert('Harap berikan rating untuk semua kategori sebelum mengirim feedback.');
        }
      });

      function initializeStarRatings() {
        document.querySelectorAll('.rating-stars').forEach(container => {
          const category = container.dataset.category;
          const input = document.getElementById(category);
          const stars = container.querySelectorAll('.star');
          const current = parseInt(input.value) || 0;
          updateStars(stars, current);
          stars.forEach(star => {
            star.addEventListener('click', () => {
              const rating = parseInt(star.dataset.rating);
              input.value = rating;
              updateStars(stars, rating);
            });
            star.addEventListener('mouseover', () => highlightStars(stars, parseInt(star.dataset.rating)));
          });
          container.addEventListener('mouseleave', () => updateStars(stars, parseInt(input.value) || 0));
        });
      }

      function updateStars(stars, rating) {
        stars.forEach((s, i) => s.classList.toggle('active', i < rating));
      }

      function highlightStars(stars, rating) {
        stars.forEach((s, i) => s.style.color = i < rating ? '#ffc107' : '#ddd');
      }
    });
  </script>

</body>
</html>
