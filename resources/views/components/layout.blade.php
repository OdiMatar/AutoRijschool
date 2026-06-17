<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Autorijschool Odai' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
</head>
<body class="bg-light app-shell">
    <nav class="navbar navbar-expand-lg sticky-top app-navbar">
        <div class="container">
            <a class="navbar-brand fw-semibold d-flex align-items-center gap-2" href="{{ auth()->check() ? route('home') : route('landing') }}">
                <span class="app-brand-mark">OA</span>
                <span>Autorijschool Odai</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Menu openen">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item"><a class="nav-link app-nav-link" href="{{ route('home') }}">Dashboard</a></li>
                        <li class="nav-item"><a class="nav-link app-nav-link" href="{{ route('instructeurs.index') }}">Instructeurs in dienst</a></li>
                        <li class="nav-item"><a class="nav-link app-nav-link" href="{{ route('voertuigen.alles') }}">Alle voertuigen</a></li>
                        <li class="nav-item"><a class="nav-link app-nav-link" href="{{ route('privacy') }}">Privacy</a></li>
                    @else
                        <li class="nav-item"><a class="nav-link app-nav-link" href="{{ route('landing') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link app-nav-link" href="{{ route('privacy') }}">Privacy</a></li>
                    @endauth
                </ul>

                <div class="d-flex align-items-center gap-2">
                    @auth
                        <span class="badge app-user-badge">{{ auth()->user()->name }}</span>
                        <form method="post" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary btn-sm app-logout-btn">Uitloggen</button>
                        </form>
                    @else
                        <a class="btn btn-outline-primary btn-sm" href="{{ route('login') }}">Inloggen</a>
                        <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Registreren</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main class="container py-4">
        @if (session('success'))
            <div class="alert alert-success app-flash">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger app-flash">{{ session('error') }}</div>
        @endif

        {{ $slot }}
    </main>

    <footer class="app-footer">
        <div class="container app-footer-inner">
            <div>
                <strong>Autorijschool Odai</strong>
                <p class="mb-0">Veilig, duidelijk en met plezier op weg naar je rijbewijs.</p>
            </div>
            <div class="app-footer-meta">
                <span>KVK: 12345678</span>
                <span>info@autorijschoolodai.nl</span>
                <span>+31 6 1234 5678</span>
                <a href="{{ route('privacy') }}">Privacy</a>
            </div>
        </div>
    </footer>

    <div class="privacy-consent" id="privacyConsent" hidden>
        <div>
            <strong>Privacy en cookies</strong>
            <p class="mb-0">Deze website gebruikt noodzakelijke cookies voor inloggen, beveiliging en formulieren.</p>
        </div>
        <div class="privacy-consent-actions">
            <a class="btn btn-outline-secondary btn-sm" href="{{ route('privacy') }}">Privacy lezen</a>
            <button class="btn btn-primary btn-sm" type="button" id="privacyConsentAccept">Akkoord</button>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        const privacyConsent = document.getElementById('privacyConsent');
        const privacyConsentAccept = document.getElementById('privacyConsentAccept');

        if (privacyConsent && localStorage.getItem('privacyConsentAccepted') !== 'yes') {
            privacyConsent.hidden = false;
        }

        privacyConsentAccept?.addEventListener('click', () => {
            localStorage.setItem('privacyConsentAccepted', 'yes');
            privacyConsent.hidden = true;
        });
    </script>
</body>
</html>
