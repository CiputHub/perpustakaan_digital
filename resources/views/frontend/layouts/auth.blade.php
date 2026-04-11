<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Auth</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Style tambahan -->
    <style>
        body {
            background: linear-gradient(135deg, #4e73df, #1cc88a);
            min-height: 100vh;
        }

        .auth-card {
            border-radius: 15px;
        }
    </style>
</head>

<body>

    <div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
        <div class="col-md-5">
            @yield('content')
        </div>
    </div>

</body>

</html>
