<x-layout title="Door instructeur gebruikte voertuigen">
    <script type="application/json" id="react-page" data-page="InstructorVehicles">@json([
        'instructeur' => $instructeur,
        'voertuigen' => $voertuigen,
    ])</script>
</x-layout>
