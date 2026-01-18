<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Regjistrohu - Brillant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            background: #f5f7fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .register-card {
            border-radius: 1rem;
            padding: 2rem;
            background-color: white;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #dc3545;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #bb2d3b;
        }
        .footer-link {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.95rem;
        }
        .footer-link a {
            text-decoration: none;
            color: #dc3545;
        }
        .footer-link a:hover {
            text-decoration: underline;
        }
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .logo-container img {
            max-width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="register-card">

                <!-- LOGO -->
                <div class="logo-container">
                    <img src="{{ asset('images/llogo.png') }}" alt="Brillant Logo">
                </div>

                <h3 class="text-center mb-4 fw-bold text-danger">Regjistro llogari të re</h3>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Emri</label>
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email adresa</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Fjalëkalimi</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmo fjalëkalimin</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-user-plus me-2"></i> Regjistrohu
                        </button>
                    </div>
                </form>

                <div class="footer-link">
                    Ke llogari? <a href="{{ route('login') }}">Kyçu</a>
                </div>

            </div>
        </div>
    </div>
</div>
</body>
</html>
