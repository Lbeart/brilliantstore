<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Kyçu - Brillant</title>
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
        .login-card {
            border-radius: 1rem;
            padding: 2rem;
            background-color: white;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
        }
        .form-control:focus {
            box-shadow: none;
            border-color: #dc3545;
        }
        .btn-primary {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-primary:hover {
            background-color: #bb2d3b;
        }
        .footer-link, .forgot-password {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.95rem;
        }
        .footer-link a, .forgot-password a {
            text-decoration: none;
            color: #dc3545;
        }
        .footer-link a:hover, .forgot-password a:hover {
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
    @if (session('verified'))
        <div class="alert alert-success text-center">
            {{ session('verified') }}
        </div>
    @endif

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card">

                    <!-- LOGO -->
                    <div class="logo-container">
                        <img src="{{ asset('images/llogo.png') }}" alt="Brillant Logo">
                    </div>

                    <!-- KTHEHU TE FAQJA KRYESORE -->
                    <div class="mb-3 text-center">
                        <a href="{{ url('/') }}" class="btn btn-outline-danger btn-sm w-100 d-md-inline-block d-block">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kthehu te Faqja Kryesore
                        </a>
                    </div>

                    <h3 class="text-center mb-4 fw-bold text-danger">Kyçu në llogarinë tënde</h3>

                    @if(session('error'))
                        <div class="alert alert-danger text-center">{{ session('error') }}</div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email adresa</label>
                            <input type="email" class="form-control" id="email" name="email" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Fjalëkalimi</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>

                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-sign-in-alt me-2"></i> Kyçu
                            </button>
                        </div>

                        <div class="forgot-password">
                            <a href="{{ route('password.request') }}">Keni harruar fjalëkalimin?</a>
                        </div>
                    </form>

                    <div class="footer-link">
                        Nuk ke llogari? <a href="{{ route('register') }}">Krijo një të re</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
