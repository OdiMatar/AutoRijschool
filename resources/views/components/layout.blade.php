<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Autorijschool Odai' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])
</head>
<body class="bg-light app-shell">
    <div
        id="react-root"
        data-shell='@json([
            "auth" => [
                "check" => auth()->check(),
                "user" => auth()->check() ? [
                    "name" => auth()->user()->name,
                    "role" => auth()->user()->role,
                    "canManageVehicles" => auth()->user()->canManageVehicles(),
                ] : null,
            ],
            "csrf" => csrf_token(),
            "flash" => [
                "success" => session("success"),
                "error" => session("error"),
            ],
            "routes" => [
                "landing" => route("landing"),
                "privacy" => route("privacy"),
                "login" => route("login"),
                "loginStore" => route("login.store"),
                "register" => route("register"),
                "registerStore" => route("register.store"),
                "logout" => auth()->check() ? route("logout") : null,
                "home" => auth()->check() ? route("home") : route("landing"),
                "accounts" => auth()->check() && auth()->user()->role === "administrator" ? route("accounts.index") : null,
                "lespakketten" => auth()->check() ? route("lesrijpakketten.index") : null,
                "instructeurs" => auth()->check() ? route("instructeurs.index") : null,
                "voertuigenAlles" => auth()->check() ? route("voertuigen.alles") : null,
            ],
        ])'
    >
        {{ $slot }}
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
