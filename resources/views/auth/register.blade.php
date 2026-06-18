<x-layout title="Registreren">
    <script type="application/json" id="react-page" data-page="Register">@json([
        'roles' => $roles,
        'errors' => $errors->toArray(),
        'old' => [
            'name' => old('name'),
            'email' => old('email'),
            'role' => old('role', 'instructeur'),
        ],
    ])</script>
</x-layout>
