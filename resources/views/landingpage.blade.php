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
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            background-color: #526D82;
        }
        .hero2 {
          background-color: #526D82;
          color: white;
          padding: 80px 0;
          position: relative;
          z-index: 1;
        }
        .card-container {
          display: flex;
          justify-content: center;
          flex-wrap: wrap;
          gap: 30px;
          margin-top: 40px;
        }
        .card {
          background: white;
          color: #333;
          border-radius: 15px;
          width: 300px;
          padding: 30px;
          text-align: center;
          transition: transform 0.3s ease;
          box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .card:hover {
          transform: translateY(-5px);
        }
        .icon-small {
          width: 80px;
          height: 80px;
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
<!--- Landing Page Section --->
<section class="hero">
  <h1 class="display-5 fw-bold text-white">-Your Beauty, Our Priority-</h1>
  <p class="lead mt-3 w-75 mx-auto text-white">
    Rasakan pengalaman beauty treatment premium dengan teknologi terdepan dan layanan dokter berpengalaman.
    Wujudkan kecantikan impian Anda bersama kami.
  </p>
  <div class="mt-4">
    <a href="#" class="btn btn-light btn-lg me-2">Login</a>
    <a href="#" class="btn btn-outline-light btn-lg">Daftar Sekarang</a>
  </div>
</section>

<!-- Why Choose Us Section -->
<section class="hero2 py-5 text-center text-white">
  <div class="container">
    <h2 class="fw-bold mb-3">Mengapa Memilih Gracies Clinic?</h2>
    <p class="mb-5">Kami berkomitmen memberikan pelayanan terbaik dengan standar internasional untuk kepuasan dan keamanan Anda</p>
    
    <div class="row justify-content-center g-4">
      <!--- card 1 --->
      <div class="col-md-5 col-lg-4">
        <div class="card h-100 border-0 shadow-sm p-4 text-dark">
          <img src="https://cdn-icons-png.flaticon.com/512/3774/3774299.png" class="mx-auto mb-3 icon-small" alt="Dokter Berpengalaman">
          <h5 class="fw-bold">Dokter Berpengalaman</h5>
          <p>Tim dokter ahli dengan pengalaman lebih dari 10 tahun di bidang kecantikan</p>
        </div>
      </div>
      <!--- card 2 --->
      <div class="col-md-5 col-lg-4">
        <div class="card h-100 border-0 shadow-sm p-4 text-dark">
          <img src="https://cdn-icons-png.flaticon.com/512/4403/4403497.png" class="mx-auto mb-3 icon-small" alt="Fasilitas Modern">
          <h5 class="fw-bold">Fasilitas Modern</h5>
          <p>Peralatan medis terkini dan teknologi canggih untuk hasil optimal</p>
        </div>
      </div>
      <!--- card 3 --->
      <div class="col-md-5 col-lg-4">
        <div class="card h-100 border-0 shadow-sm p-4 text-dark">
          <img src="https://cdn-icons-png.flaticon.com/512/860/860916.png" class="mx-auto mb-3 icon-small" alt="Treatment Berkualitas">
          <h5 class="fw-bold">Treatment Berkualitas</h5>
          <p>Prosedur yang aman, teruji klinis, dan mengikuti standar internasional</p>
        </div>
      </div>
      <!--- card 4 --->
      <div class="col-md-5 col-lg-4">
        <div class="card h-100 border-0 shadow-sm p-4 text-dark">
          <img src="https://cdn-icons-png.flaticon.com/512/747/747310.png" class="mx-auto mb-3 icon-small" alt="Reservasi Mudah">
          <h5 class="fw-bold">Reservasi Mudah</h5>
          <p>Sistem booking online yang mudah dan fleksibel sesuai jadwal Anda</p>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
