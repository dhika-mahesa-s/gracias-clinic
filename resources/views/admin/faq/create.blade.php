<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah FAQ - Gracias Clinic</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: "Poppins", sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding-top: 90px; /* supaya konten tidak ketutup navbar */
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

        main {
            background-color: white;
            width: 90%;
            max-width: 600px;
            margin: 60px auto;
            padding: 40px 50px;
            border-radius: 16px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h1 {
            font-size: 24px;
            text-align: center;
            margin-bottom: 30px;
            color: #2b2b2b;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 15px;
            transition: border-color 0.3s ease;
        }

        input[type="text"]:focus,
        textarea:focus {
            border-color: #4b5a68;
            outline: none;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-size: 15px;
            transition: 0.3s;
        }

        .btn-save {
            background-color: #4b5a68;
            color: white;
        }

        .btn-save:hover {
            background-color: #2e8b8b;
        }

        .btn-cancel {
            background-color: #ccc;
            color: #333;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            display: inline-block;
        }

        .btn-cancel:hover {
            background-color: #aaa;
        }

        .form-buttons {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
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

    <!-- Main Content -->
    <main>
        <h1>Tambah FAQ Baru</h1>

        <form action="{{ url('admin/faq') }}" method="POST">
            @csrf
            <label>Pertanyaan:</label>
            <input type="text" name="question" required>

            <label>Jawaban:</label>
            <textarea name="answer" rows="4" required></textarea>

            <div class="form-buttons">
                <button type="submit" class="btn btn-save">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                </button>
                <a href="{{ url('admin/faq') }}" class="btn btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
            </div>
        </form>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
