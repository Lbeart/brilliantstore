<!DOCTYPE html>
<html lang="sq">
<head>
    <meta charset="UTF-8">
    <title>Kyçu - Brillant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ asset('images/llogo.png') }}">

    <style>
        :root {
            --brand: #dc3545;
            --brand-dark: #b52a37;
            --ink: #111827;
            --muted: #6b7280;
            --line: #e5e7eb;
            --surface: rgba(255, 255, 255, .92);
            --shadow: 0 26px 70px rgba(15, 23, 42, .16);
        }

        * { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            font-family: "Poppins", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--ink);
            background:
                linear-gradient(135deg, rgba(220, 53, 69, .10), rgba(255, 193, 7, .10)),
                #f6f7fb;
        }

        .auth-page {
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px 16px;
        }

        .auth-shell {
            width: min(1060px, 100%);
            display: grid;
            grid-template-columns: 1.02fr .98fr;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .8);
            border-radius: 28px;
            background: var(--surface);
            box-shadow: var(--shadow);
            backdrop-filter: blur(14px);
        }

        .brand-panel {
            position: relative;
            min-height: 650px;
            padding: 34px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #fff;
            background:
                linear-gradient(150deg, rgba(15, 23, 42, .88), rgba(15, 23, 42, .34)),
                url("{{ asset('slider/foto1.jpg') }}") center/cover no-repeat;
        }

        .brand-mark {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            width: fit-content;
            padding: 10px 14px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .14);
            border: 1px solid rgba(255, 255, 255, .22);
        }

        .brand-mark img {
            width: 42px;
            height: 42px;
            object-fit: contain;
            border-radius: 50%;
            background: #fff;
            padding: 4px;
        }

        .brand-mark span {
            font-size: .9rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .brand-copy h1 {
            max-width: 520px;
            margin: 0 0 14px;
            font-size: clamp(2rem, 4vw, 3.6rem);
            line-height: 1.04;
            font-weight: 800;
        }

        .brand-copy p {
            max-width: 480px;
            margin: 0;
            color: rgba(255, 255, 255, .86);
            line-height: 1.75;
            font-weight: 500;
        }

        .brand-points {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 10px;
        }

        .brand-point {
            padding: 14px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .12);
            border: 1px solid rgba(255, 255, 255, .18);
            font-size: .86rem;
            font-weight: 700;
        }

        .form-panel {
            padding: clamp(26px, 5vw, 54px);
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #fff;
        }

        .mobile-logo {
            display: none;
            width: 96px;
            margin: 0 auto 18px;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            margin-bottom: 26px;
            color: var(--muted);
            font-weight: 700;
            text-decoration: none;
        }

        .back-link:hover { color: var(--brand); }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            width: fit-content;
            margin-bottom: 12px;
            padding: 7px 12px;
            border-radius: 999px;
            background: rgba(220, 53, 69, .08);
            color: var(--brand);
            font-size: .78rem;
            font-weight: 800;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .auth-title {
            margin: 0;
            font-size: clamp(1.8rem, 3vw, 2.45rem);
            font-weight: 800;
            letter-spacing: 0;
        }

        .auth-subtitle {
            margin: 10px 0 28px;
            color: var(--muted);
            line-height: 1.65;
        }

        .form-label {
            color: #374151;
            font-weight: 700;
            font-size: .92rem;
        }

        .field-wrap {
            position: relative;
        }

        .field-wrap i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            pointer-events: none;
        }

        .form-control {
            height: 52px;
            border-radius: 14px;
            border: 1px solid var(--line);
            padding-left: 46px;
            font-weight: 600;
            background: #f9fafb;
        }

        .form-control:focus {
            border-color: rgba(220, 53, 69, .65);
            box-shadow: 0 0 0 4px rgba(220, 53, 69, .12);
            background: #fff;
        }

        .is-invalid {
            border-color: #dc3545;
        }

        .btn-auth {
            min-height: 52px;
            border: 0;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--brand), var(--brand-dark));
            color: #fff;
            font-weight: 800;
            box-shadow: 0 14px 28px rgba(220, 53, 69, .25);
        }

        .btn-auth:hover {
            color: #fff;
            filter: brightness(.98);
            transform: translateY(-1px);
        }

        .support-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            margin: 16px 0 0;
            font-size: .93rem;
        }

        .auth-link {
            color: var(--brand);
            font-weight: 800;
            text-decoration: none;
        }

        .auth-link:hover { text-decoration: underline; }

        .switch-box {
            margin-top: 28px;
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #f9fafb;
            text-align: center;
            color: var(--muted);
            font-weight: 600;
        }

        .alert {
            border: 0;
            border-radius: 14px;
            font-weight: 600;
        }

        @media (max-width: 900px) {
            .auth-shell {
                grid-template-columns: 1fr;
                border-radius: 22px;
            }

            .brand-panel { display: none; }

            .form-panel { padding: 30px 20px; }

            .mobile-logo { display: block; }

            .back-link { margin-bottom: 20px; }
        }
    </style>
</head>
<body>
    <main class="auth-page">
        <section class="auth-shell" aria-label="Kyçu në Brillant">
            <aside class="brand-panel">
                <div class="brand-mark">
                    <img src="{{ asset('images/llogo.png') }}" alt="Brillant">
                    <span>Brillant</span>
                </div>

                <div class="brand-copy">
                    <h1>Mirë se erdhe prapë.</h1>
                    <p>Kyçu në llogarinë tënde për të vazhduar me porositë, shportën dhe produktet e preferuara nga Brillant.</p>
                </div>

                <div class="brand-points">
                    <div class="brand-point"><i class="fa-solid fa-shield-halved me-2"></i> Llogari e sigurt</div>
                    <div class="brand-point"><i class="fa-solid fa-bag-shopping me-2"></i> Porosi online</div>
                    <div class="brand-point"><i class="fa-solid fa-truck-fast me-2"></i> Dërgesë e shpejtë</div>
                </div>
            </aside>

            <div class="form-panel">
                <img class="mobile-logo" src="{{ asset('images/llogo.png') }}" alt="Brillant Logo">

                <a href="{{ url('/') }}" class="back-link">
                    <i class="fa-solid fa-arrow-left"></i>
                    Kthehu te faqja kryesore
                </a>

                <span class="eyebrow"><i class="fa-solid fa-lock"></i> Kyçje</span>
                <h2 class="auth-title">Kyçu në llogarinë tënde</h2>
                <p class="auth-subtitle">Vazhdo shpejt dhe sigurt me email adresën dhe fjalëkalimin tënd.</p>

                @if (session('verified'))
                    <div class="alert alert-success">
                        {{ session('verified') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        Kontrollo të dhënat dhe provo përsëri.
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email adresa</label>
                        <div class="field-wrap">
                            <i class="fa-regular fa-envelope"></i>
                            <input
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required
                                autofocus>
                        </div>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-2">
                        <label for="password" class="form-label">Fjalëkalimi</label>
                        <div class="field-wrap">
                            <i class="fa-solid fa-key"></i>
                            <input
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                id="password"
                                name="password"
                                autocomplete="current-password"
                                required>
                        </div>
                        @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="support-row">
                        <span class="text-muted">Të dhënat ruhen të sigurta.</span>
                        <a href="{{ route('password.request') }}" class="auth-link">Harruat fjalëkalimin?</a>
                    </div>

                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-auth">
                            <i class="fas fa-sign-in-alt me-2"></i> Kyçu
                        </button>
                    </div>
                </form>

                <div class="switch-box">
                    Nuk ke llogari?
                    <a href="{{ route('register') }}" class="auth-link">Krijo një të re</a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
