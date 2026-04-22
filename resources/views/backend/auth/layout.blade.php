<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>

    <!-- Bootstrap 5 CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #1768ff 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Pattern Perpustakaan */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cpath fill='rgba(255,255,255,0.05)' d='M45.3,-70.6C59.1,-61.4,71.1,-47.1,77.5,-30.5C83.9,-13.9,84.7,5.1,78.1,20.5C71.5,35.9,57.5,47.8,42.2,57.2C26.9,66.6,10.2,73.5,-7.4,74.2C-25,74.9,-43.4,69.4,-56.2,58.1C-69,46.8,-76.2,29.7,-77.6,11.8C-79,-6.1,-74.6,-24.9,-63.8,-40.5C-53,-56.1,-35.9,-68.5,-18.5,-73.9C-1.1,-79.3,16.4,-77.6,31.5,-79.8C46.6,-82,59.6,-70.6,45.3,-70.6Z'/%3E%3C/svg%3E");
            background-repeat: repeat;
            opacity: 0.3;
            pointer-events: none;
        }

        /* Buku Animasi */
        .book-decoration {
            position: absolute;
            bottom: 20px;
            left: 20px;
            opacity: 0.15;
            pointer-events: none;
        }

        .book-decoration i {
            font-size: 80px;
            color: white;
            margin-right: -20px;
        }

        /* Container */
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        /* Card Login */
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
            transition: transform 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .login-card:hover {
            transform: translateY(-5px);
        }

        /* Header Card */
        .login-header {
            background: linear-gradient(135deg, #667eea 0%, #4b82a2 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .login-header .icon {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .login-header h3 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .login-header p {
            opacity: 0.9;
            font-size: 14px;
            margin: 0;
        }

        /* Body Card */
        .login-body {
            padding: 35px;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        .form-group label i {
            margin-right: 8px;
            color: #667eea;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            outline: none;
        }

        /* Button */
        .btn-login {
            background: linear-gradient(135deg, #667eea 0%, #29a7c7 100%);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            font-size: 16px;
            width: 100%;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(63, 98, 255, 0.3);
        }

        /* Alert */
        .alert-custom {
            border-radius: 12px;
            border: none;
            padding: 12px 16px;
            font-size: 14px;
            margin-bottom: 20px;
        }

        .alert-danger-custom {
            background: #fee2e2;
            color: #dc2626;
        }

        /* Footer */
        .login-footer {
            text-align: center;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
            margin-top: 10px;
        }

        .login-footer a {
            color: #667eea;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .login-footer a:hover {
            color: #764ba2;
        }

        /* Floating Books */
        .floating-books {
            position: fixed;
            bottom: 30px;
            right: 30px;
            opacity: 0.2;
            pointer-events: none;
        }

        .floating-books i {
            font-size: 60px;
            color: white;
            margin-left: -15px;
        }

        /* Quote */
        .quote {
            position: fixed;
            bottom: 30px;
            left: 30px;
            color: white;
            font-size: 12px;
            opacity: 0.6;
            z-index: 1;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .login-body {
                padding: 25px;
            }

            .login-header {
                padding: 25px;
            }

            .quote {
                display: none;
            }
        }
    </style>
</head>

<body>
    <!-- Background Decoration -->
    <div class="book-decoration">
        <i class="fas fa-book-open"></i>
        <i class="fas fa-book"></i>
        <i class="fas fa-book-reader"></i>
    </div>

    <div class="floating-books">
        <i class="fas fa-book"></i>
        <i class="fas fa-book"></i>
        <i class="fas fa-book"></i>
    </div>

    <div class="quote">
        <i class="fas fa-quote-left me-1"></i> Membaca adalah jendela dunia
    </div>

    <div class="login-container">
        <div class="col-md-5 col-lg-4">
            <div class="login-card">
                <div class="login-header">
                    <div class="icon">
                        <i class="fas fa-book-open"></i>
                    </div>
                    <h3>Perpustakaan Digital</h3>
                    <p>Login untuk mengakses dashboard</p>
                </div>

                <div class="login-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
