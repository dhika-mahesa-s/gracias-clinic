<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - Gracias Aesthetic Clinic</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding-top: 90px; /* biar ga ketutup navbar */
            color: #2b2b2b;
        }

        /* Navbar */
        .navbar {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(8px);
        }

        .navbar-brand {
            font-weight: bold;
            font-family: 'Playfair Display', serif;
        }

        .navbar-brand img {
            margin-right: 10px;
        }

        .nav-link {
            color: #333 !important;
            font-weight: 400;
        }

        .nav-link:hover,
        .nav-link.active {
            color: #2e8b8b !important;
        }

        /* FAQ Section */
        main {
            background-color: #fff;
            border-radius: 16px;
            max-width: 800px;
            margin: 60px auto;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-weight: 600;
            font-size: 26px;
            margin-bottom: 30px;
            text-align: center;
        }

        /* Accordion style */
        .accordion-button:not(.collapsed) {
            background-color: #eaeaea;
            color: #2b2b2b;
        }

        .accordion-button:focus {
            box-shadow: none;
            border-color: #ccc;
        }

        /* Footer wave */
        .footer-wave {
            width: 100%;
            height: 120px;
            background: #4b5a68;
            clip-path: ellipse(100% 100% at 50% 100%);
            margin-top: 50px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" width="50" height="50">
                Gracias Aesthetic Clinic
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link active" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Our Team</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Product</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Promo</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- FAQ Section -->
    <main>
        <h2>Frequently Asked Questions</h2>

        <div class="accordion" id="faqAccordion">
            @foreach ($faqs as $index => $faq)
            <div class="accordion-item">
                <h2 class="accordion-header" id="heading{{ $index }}">
                    <button class="accordion-button {{ $index != 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                        {{ $faq->question }}
                    </button>
                </h2>
                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </main>

    <!-- Footer -->
    <div class="footer-wave"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
