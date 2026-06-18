<x-layout title="Inloggen">
    <script type="application/json" id="react-page" data-page="Login">@json([
        'errors' => $errors->toArray(),
        'old' => [
            'email' => old('email'),
        ],
    ])</script>
</x-layout>
