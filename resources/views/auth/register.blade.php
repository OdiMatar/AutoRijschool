<x-layout title="Registreren">
    <section class="d-grid" style="min-height: calc(100vh - 160px); place-items: center;">
        <div class="card shadow-sm" style="max-width: 460px; width: 100%;">
            <div class="card-body p-4">
            <p class="text-uppercase small fw-semibold text-secondary mb-2">Nieuw account</p>
            <h1 class="h3 mb-4">Registreren</h1>

            <form method="post" action="{{ route('register.store') }}" class="d-grid gap-3">
                @csrf

                <label class="form-label mb-0">
                    Naam
                    <input class="form-control mt-1" name="name" value="{{ old('name') }}" required autofocus>
                    @error('name')<span class="text-danger small">{{ $message }}</span>@enderror
                </label>

                <label class="form-label mb-0">
                    E-mailadres
                    <input class="form-control mt-1" type="email" name="email" value="{{ old('email') }}" required>
                    @error('email')<span class="text-danger small">{{ $message }}</span>@enderror
                </label>

                <label class="form-label mb-0">
                    Rol
                    <select class="form-select mt-1" name="role" required>
                        @foreach ($roles as $value => $label)
                            <option value="{{ $value }}" @selected(old('role', 'instructeur') === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('role')<span class="text-danger small">{{ $message }}</span>@enderror
                </label>

                <label class="form-label mb-0">
                    Wachtwoord
                    <input class="form-control mt-1" type="password" name="password" required>
                    @error('password')<span class="text-danger small">{{ $message }}</span>@enderror
                </label>

                <label class="form-label mb-0">
                    Herhaal wachtwoord
                    <input class="form-control mt-1" type="password" name="password_confirmation" required>
                </label>

                <button class="btn btn-primary" type="submit">Registreren</button>
            </form>

            <p class="mt-3 mb-0">Heb je al een account? <a href="{{ route('login') }}">Inloggen</a></p>
            </div>
        </div>
    </section>
</x-layout>
