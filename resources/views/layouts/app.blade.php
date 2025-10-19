<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gracias Aesthetic Clinic - Feedback</title>

    <!-- ✅ Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ✅ Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Playfair+Display:wght@600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e2ebf0 0%, #f7f9fb 100%);
            padding-top: 80px; /* ruang agar tidak tertutup navbar */
        }

        /* 🌟 Navbar Glass Effect */
        .navbar {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
        }

        .navbar:hover {
            background: rgba(255, 255, 255, 0.9);
        }

        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
            color: #222;
            font-size: 1.2rem;
            letter-spacing: 0.3px;
            transition: color 0.3s ease;
        }

        .navbar-brand img {
            margin-right: 8px;
        }

        .navbar-nav .nav-link {
            color: #333;
            font-weight: 500;
            margin-right: 1rem;
            transition: all 0.25s ease;
            position: relative;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 3px;
            width: 0%;
            height: 2px;
            background: #333;
            transition: width 0.25s ease;
        }

        .navbar-nav .nav-link:hover::after,
        .navbar-nav .nav-link.active::after {
            width: 100%;
        }

        .navbar-nav .nav-link:hover {
            color: #000;
        }

        /* 🔘 Tombol */
        .btn-outline-dark {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .btn-outline-dark:hover {
            background: #333;
            color: #fff;
        }

        .btn-dark {
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.25s ease;
        }

        .btn-dark:hover {
            background: #000;
            transform: translateY(-2px);
        }

        /* 🌿 Footer */
        footer {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
        }
    </style>
</head>

<body>
    <!-- 🌟 Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="50" height="50">
                Gracias Aesthetic Clinic
            </a>
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

    <!-- 🌸 Main Content -->
    <main class="py-4">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- 🌙 Footer -->
    <footer class="text-center py-3 border-top mt-5">
        <small>© {{ date('Y') }} Gracias Aesthetic Clinic. All rights reserved.</small>
    </footer>

    <!-- ✅ Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
