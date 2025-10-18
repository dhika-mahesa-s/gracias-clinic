<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gracias Aesthetic Clinic</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
        }
        .hero {
            background: url('{{ asset("images/clinic-bg.jpg") }}') no-repeat center center/cover;
            height: 100vh;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-color: rgba(0,0,0,0.5);
            background-blend-mode: darken;
        }
        .navbar {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
        }
        .navbar-brand {
            font-weight: bold;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
  <div class="container">
    <a class="navbar-brand" href="#">Gracias Aesthetic Clinic</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Treatments</a></li>
        <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
        <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
      </ul>
      <a href="#" class="btn btn-outline-dark ms-3">Login</a>
      <a href="#" class="btn btn-dark ms-2">Daftar Sekarang</a>
    </div>
  </div>
</nav>

<section class="hero">
  <h1 class="display-5 fw-bold">-Your Beauty, Our Priority-</h1>
  <p class="lead mt-3 w-75 mx-auto">
    Rasakan pengalaman beauty treatment premium dengan teknologi terdepan dan layanan dokter berpengalaman.
    Wujudkan kecantikan impian Anda bersama kami.
  </p>
  <div class="mt-4">
    <a href="#" class="btn btn-light btn-lg me-2">Login</a>
    <a href="#" class="btn btn-outline-light btn-lg">Daftar Sekarang</a>
  </div>
</section>

<!-- Why Choose Us Section -->
<section id="why-choose-us" class="py-20 bg-[#45586B] text-white">
    <div class="max-w-6xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Mengapa Memilih Gracies Clinic?</h2>
        <p class="text-lg mb-12">
            Kami berkomitmen memberikan pelayanan terbaik dengan standar internasional
            untuk kepuasan dan keamanan Anda
        </p>

        <!-- Grid Container -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Card 1 -->
            <div class="bg-white text-gray-800 p-8 rounded-2xl shadow-lg flex flex-col items-center hover:scale-105 transition-transform duration-300">
                <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" alt="Dokter" class="w-20 mb-4">
                <h3 class="text-xl font-semibold mb-2">Dokter Berpengalaman</h3>
                <p>Tim dokter ahli dengan pengalaman lebih dari 10 tahun di bidang kecantikan</p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white text-gray-800 p-8 rounded-2xl shadow-lg flex flex-col items-center hover:scale-105 transition-transform duration-300">
                <img src="https://cdn-icons-png.flaticon.com/512/4403/4403497.png" alt="Fasilitas" class="w-20 mb-4">
                <h3 class="text-xl font-semibold mb-2">Fasilitas Modern</h3>
                <p>Peralatan medis terkini dan teknologi canggih untuk hasil optimal</p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white text-gray-800 p-8 rounded-2xl shadow-lg flex flex-col items-center hover:scale-105 transition-transform duration-300">
                <img src="https://cdn-icons-png.flaticon.com/512/860/860916.png" alt="Treatment" class="w-20 mb-4">
                <h3 class="text-xl font-semibold mb-2">Treatment Berkualitas</h3>
                <p>Prosedur yang aman, teruji klinis, dan mengikuti standar internasional</p>
            </div>

            <!-- Card 4 -->
            <div class="bg-white text-gray-800 p-8 rounded-2xl shadow-lg flex flex-col items-center hover:scale-105 transition-transform duration-300">
                <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" alt="Reservasi" class="w-20 mb-4">
                <h3 class="text-xl font-semibold mb-2">Reservasi Mudah</h3>
                <p>Sistem booking online yang mudah dan fleksibel sesuai jadwal Anda</p>
            </div>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
