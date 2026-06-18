<x-layout title="Wijzigen voertuiggegevens">
    <script type="application/json" id="react-page" data-page="EditVehicle">@json([
        'instructeur' => $instructeur,
        'voertuig' => $voertuig,
        'instructeurs' => $instructeurs->map(fn ($rijInstructeur) => [
            'Id' => $rijInstructeur->Id,
            'VolledigeNaam' => $rijInstructeur->VolledigeNaam,
        ]),
        'typeVoertuigen' => $typeVoertuigen,
        'brandstoffen' => $brandstoffen,
        'errors' => $errors->toArray(),
        'old' => [
            'InstructeurId' => old('InstructeurId'),
            'TypeVoertuigId' => old('TypeVoertuigId'),
            'Type' => old('Type'),
            'Brandstof' => old('Brandstof'),
            'Kenteken' => old('Kenteken'),
        ],
    ])</script>
</x-layout>
