<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin FAQ - Gracias Clinic</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&family=Playfair+Display:wght@500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f9f9f9;
            color: #2b2b2b;
            padding-top: 90px; /* agar konten tidak tertutup navbar */
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

        /* Main content */
        main {
            background-color: white;
            border-radius: 16px;
            max-width: 1000px;
            margin: 60px auto;
            padding: 40px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        h2 {
            font-weight: 600;
            font-size: 26px;
            margin-bottom: 30px;
        }

        .add-faq {
            display: inline-block;
            background-color: #4b5a68;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin-bottom: 20px;
            font-size: 15px;
            transition: 0.3s;
        }

        .add-faq:hover {
            background-color: #2e8b8b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 15px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 16px;
            text-align: left;
            vertical-align: top;
        }

        th {
            background-color: #f2f2f2;
            color: #444;
            font-weight: 600;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 18px;
            color: #4b5a68;
            transition: 0.2s;
        }

        .btn:hover {
            color: #2e8b8b;
        }

        /* Footer Wave */
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

    <!-- Main Section -->
    <main>
        <h2>Kelola FAQ</h2>

        <a href="{{ url('admin/faq/create') }}" class="add-faq">
            <i class="fa-solid fa-plus"></i> Tambah FAQ
        </a>

        <table>
            <thead>
                <tr>
                    <th>Pertanyaan</th>
                    <th>Jawaban</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faqs as $faq)
                <tr>
                    <td>{{ $faq->question ?? $faq->pertanyaan }}</td>
                    <td>{{ $faq->answer ?? $faq->jawaban }}</td>
                    <td>
                        <div class="action-buttons">
                            <a href="{{ url('admin/faq/'.$faq->id.'/edit') }}" class="btn" title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                            <form action="{{ url('admin/faq/'.$faq->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus FAQ ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn" title="Hapus">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </main>

    <!-- Footer -->
    <div class="footer-wave"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
