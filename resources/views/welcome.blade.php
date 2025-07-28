<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selamat Datang di SIMPUS</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background-color: #f4f7f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .container {
            text-align: center;
            background: white;
            padding: 50px 60px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 20px;
        }

        .logo {
            width: 80px;
            margin-bottom: 20px;
        }

        h1 {
            color: #2c3e50;
            font-weight: 700;
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        p {
            color: #7f8c8d;
            font-size: 1.1em;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .login-button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 15px 35px;
            font-size: 1.2em;
            font-weight: 600;
            text-decoration: none;
            border-radius: 50px;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.2);
        }

        .login-button:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

    <div class="container">
        {{-- Anda bisa mengganti logo ini dengan logo puskesmas Anda --}}
        <img src="https://img.icons8.com/color/96/000000/clinic.png" alt="Logo Puskesmas" class="logo"/>

        <h1>Sistem Informasi Puskesmas</h1>
        <p>
            Selamat datang! Sistem ini dirancang untuk mempermudah pengelolaan data dan meningkatkan efisiensi pelayanan kesehatan di puskesmas kita.
        </p>

        {{-- Pastikan rute 'login' sudah ada di web.php --}}
        <a href="{{ route('login') }}" class="login-button">
            Login ke Sistem
        </a>
    </div>

</body>
</html>
