<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Gracias Clinic</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #c6cacf; color: #fff; }
    nav {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
        }
        .navbar-brand {
            font-weight: bold;
        }

  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top ">
  <div class="container">
    <a class="navbar-brand" href="#"> <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50" height="50">Gracias Aesthetic Clinic</a>
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

  <div class="container mt-5 pt-5">
    @yield('content')
  </div>
</body>
</html>
