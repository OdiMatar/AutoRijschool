<x-layout title="Inloggen">
    <section class="d-grid" style="min-height: calc(100vh - 160px); place-items: center;">
        <div class="card shadow-sm" style="max-width: 460px; width: 100%;">
            <div class="card-body p-4">
            <p class="text-uppercase small fw-semibold text-secondary mb-2">Account</p>
            <h1 class="h3 mb-4">Inloggen</h1>

            <form method="post" action="{{ route('login.store') }}" class="d-grid gap-3">
                @csrf

                <label class="form-label mb-0">
                    E-mailadres
                    <input class="form-control mt-1" type="email" name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
                </label>

                <label class="form-label mb-0">
                    Wachtwoord
                    <input class="form-control mt-1" type="password" name="password" required>
                    @error('password')<span class="text-danger small">{{ $message }}</span>@enderror
                </label>

                <label class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" value="1">
                    <span class="form-check-label">
                    Onthoud mij
                    </span>
                </label>

                <button class="btn btn-primary" type="submit">Inloggen</button>
            </form>

            <p class="mt-3 mb-0">Nog geen account? <a href="{{ route('register') }}">Registreren</a></p>
            </div>
        </div>
    </section>
</x-layout>
