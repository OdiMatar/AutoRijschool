<x-layout :title="$title">
    <script type="application/json" id="react-page" data-page="Status">@json([
        'title' => $title,
        'message' => $message,
        'redirectUrl' => $redirectUrl,
    ])</script>
</x-layout>
