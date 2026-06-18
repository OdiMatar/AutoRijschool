<x-layout title="Alle beschikbare voertuigen">
    <script type="application/json" id="react-page" data-page="AvailableVehicles">@json([
        'instructeur' => $instructeur,
        'voertuigen' => $voertuigen,
    ])</script>
</x-layout>
