<x-layout title="Lesrijpakketten Overzicht">
    <script type="application/json" id="react-page" data-page="LessonPackages">@json([
        'lesrijpakketten' => $lesrijpakketten,
        'categorieen' => $categorieen,
        'geselecteerdeCategorie' => $geselecteerdeCategorie,
    ])</script>
</x-layout>
