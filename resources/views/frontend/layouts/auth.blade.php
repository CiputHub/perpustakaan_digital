<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Perpustakaan Digital')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1a472a 0%, #2d6a4f 50%, #ffb703 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        /* Background Pattern - Buku */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 200 200'%3E%3Cpath fill='rgba(255,255,255,0.05)' d='M45.3,-70.6C59.1,-61.4,71.1,-47.1,77.5,-30.5C83.9,-13.9,84.7,5.1,78.1,20.5C71.5,35.9,57.5,47.8,42.2,57.2C26.9,66.6,10.2,73.5,-7.4,74.2C-25,74.9,-43.4,69.4,-56.2,58.1C-69,46.8,-76.2,29.7,-77.6,11.8C-79,-6.1,-74.6,-24.9,-63.8,-40.5C-53,-56.1,-35.9,-68.5,-18.5,-73.9C-1.1,-79.3,16.4,-77.6,31.5,-79.8C46.6,-82,59.6,-70.6,45.3,-70.6Z'/%3E%3C/svg%3E");
            background-repeat: repeat;
            pointer-events: none;
        }

        /* Floating Books Animation */
        .floating-books {
            position: fixed;
            bottom: 30px;
            right: 30px;
            opacity: 0.2;
            pointer-events: none;
        }

        .floating-books i {
            font-size: 80px;
            color: #ffb703;
            margin-left: -20px;
            animation: float 6s ease-in-out infinite;
        }

        .floating-books i:nth-child(2) {
            animation-delay: 1s;
            font-size: 60px;
            color: #ff9f00;
        }

        .floating-books i:nth-child(3) {
            animation-delay: 2s;
            font-size: 100px;
            color: #fb8500;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }

        /* Quote */
        .quote {
            position: fixed;
            bottom: 30px;
            left: 30px;
            color: white;
            font-size: 14px;
            opacity: 0.8;
            z-index: 1;
            font-style: italic;
            background: rgba(0,0,0,0.3);
            padding: 8px 16px;
            border-radius: 50px;
            backdrop-filter: blur(5px);
        }

        /* Main Container */
        .auth-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        /* Card */
        .auth-card {
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            transition: transform 0.3s ease;
            background: white;
        }

        .auth-card:hover {
            transform: translateY(-5px);
        }

        /* Header Card - Warna Hijau Tua */
        .auth-header {
            background: linear-gradient(135deg, #1a472a 0%, #2d6a4f 100%);
            padding: 30px;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '📚';
            position: absolute;
            font-size: 100px;
            bottom: -20px;
            right: -20px;
            opacity: 0.1;
            transform: rotate(-15deg);
        }

        .auth-header .icon {
            font-size: 48px;
            margin-bottom: 15px;
            color: #ffb703;
        }

        .auth-header h3 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .auth-header p {
            opacity: 0.9;
            font-size: 13px;
            margin: 0;
        }

        /* Body Card */
        .auth-body {
            padding: 35px;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            font-weight: 600;
            color: #1a472a;
            margin-bottom: 8px;
            display: block;
            font-size: 13px;
        }

        .form-group label i {
            margin-right: 8px;
            color: #ffb703;
            width: 18px;
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #ffb703;
            box-shadow: 0 0 0 3px rgba(255, 183, 3, 0.2);
            outline: none;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 80px;
        }

        /* Button - Warna Kuning/Oren */
        .btn-auth {
            background: linear-gradient(135deg, #ffb703 0%, #fb8500 100%);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 700;
            font-size: 16px;
            width: 100%;
            color: #1a472a;
            transition: all 0.3s ease;
        }

        .btn-auth:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(251, 133, 0, 0.3);
            color: #1a472a;
        }

        .btn-auth i {
            margin-right: 8px;
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

        .alert-success-custom {
            background: #dcfce7;
            color: #16a34a;
        }

        /* Link */
        .auth-link {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e2e8f0;
        }

        .auth-link small {
            color: #64748b;
        }

        .auth-link a {
            color: #fb8500;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .auth-link a:hover {
            color: #ffb703;
        }

        /* Row untuk 2 kolom */
        .row-auth {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }

        .col-auth {
            flex: 1;
            padding: 0 10px;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 20px 0;
            color: #94a3b8;
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }

        .divider::before {
            margin-right: 10px;
        }

        .divider::after {
            margin-left: 10px;
        }

        /* Checkbox styling */
        .form-check-input:checked {
            background-color: #ffb703;
            border-color: #ffb703;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-body {
                padding: 25px;
            }

            .auth-header {
                padding: 25px;
            }

            .quote, .floating-books {
                display: none;
            }

            .row-auth {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <!-- Floating Books Decoration -->
    <div class="floating-books">
        <i class="fas fa-book-open"></i>
        <i class="fas fa-book-reader"></i>
        <i class="fas fa-book"></i>
    </div>

    <div class="quote">
        <i class="fas fa-quote-left me-2"></i> Membaca adalah jendela dunia, buka setiap harinya
    </div>

    <div class="auth-container">
        <div class="col-md-6 col-lg-5">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
