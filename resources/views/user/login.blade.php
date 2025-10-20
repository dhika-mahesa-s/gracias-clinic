<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gracias Clinic</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #5c7d92, #7d9dad);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
            border-radius: 25px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
            width: 900px;
            overflow: hidden;
        }

        .left {
            flex: 1;
            background: url('{{ asset('images/login.jpg') }}') no-repeat center center/cover;
        }

        .right {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px;
            color: #222;
        }

        .logo {
            width: 100px;
            margin-bottom: 20px;
        }

        .login-box {
            width: 100%;
            max-width: 330px;
            background: rgba(255, 255, 255, 0.25);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            text-align: center;
        }

        .login-box h2 {
            font-size: 28px;
            font-weight: 700;
            color: #2c2c2c;
            text-shadow: 1px 2px 3px rgba(0, 0, 0, 0.3);
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
            text-align: left;
            width: 100%;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #333;
            font-size: 16px;
        }

        .input-group .fa-envelope,
        .input-group .fa-lock {
            left: 10px;
        }

        .input-group .toggle-password {
            right: 10px;
            cursor: pointer;
        }

        .input-group input {
            width: 100%;
            display: block;
            padding: 10px 40px 10px 35px;
            border: none;
            border-bottom: 0.5px solid rgba(0, 0, 0, 0.4);
            background: transparent;
            color: #000;
            font-size: 15px;
            outline: none;
            transition: border-color 0.3s ease;
            max-width: 100%;
        }

        .input-group input:focus {
            border-bottom: 0.5px solid #2e4a59;
        }

        .input-group input::placeholder {
            color: #555;
        }

        .login-btn {
            width: 100%;
            background: linear-gradient(145deg, #cfcfcf, #9b9b9b);
            border: none;
            border-radius: 25px;
            padding: 12px;
            font-size: 16px;
            font-weight: 700;
            color: #000;
            cursor: pointer;
            box-shadow: 0 5px 12px rgba(0, 0, 0, 0.3);
            transition: 0.3s ease;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            background: linear-gradient(145deg, #d8d8d8, #aaaaaa);
        }

        .bottom-links {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .bottom-links a {
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
        }

        .bottom-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="left"></div>

        <div class="right">
            <img src="{{ asset('images/logo.png') }}" alt="Gracias Clinic Logo" class="logo">

            <div class="login-box">
                <h2>Login</h2>

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="input-group">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="input-group">
                        <i class="fa-solid fa-lock"></i>
                        <input type="password" id="password" name="password" placeholder="Password" required>
                        <i class="fa-solid fa-eye toggle-password" id="togglePassword"></i>
                    </div>

                    <button type="submit" class="login-btn">Login</button>

                    <div class="bottom-links">
                        <a href="{{ route('register') }}">Create An Account</a>
                        <a href="#">Forget Password?</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Show/hide password
        const togglePassword = document.querySelector("#togglePassword");
        const passwordInput = document.querySelector("#password");
        togglePassword.addEventListener("click", function() {
            const type = passwordInput.getAttribute("type") === "password" ? "text" : "password";
            passwordInput.setAttribute("type", type);
            this.classList.toggle("fa-eye-slash");
        });
    </script>

</body>

</html>
