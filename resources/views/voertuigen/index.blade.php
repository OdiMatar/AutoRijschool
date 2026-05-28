<x-layout title="Door instructeur gebruikte voertuigen">
    <section class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="h3 mb-2">Door instructeur gebruikte voertuigen</h1>
            <div class="text-muted">
                <p class="mb-1">Naam: [{{ $instructeur->VolledigeNaam }}]</p>
                <p class="mb-1">Datum in dienst: [{{ $instructeur->DatumInDienst->format('d-m-Y') }}]</p>
                <p class="mb-0">Aantal sterren: [{{ $instructeur->AantalSterren }}]</p>
            </div>
            @if (auth()->user()->canManageVehicles())
                <a class="btn btn-primary mt-3" href="{{ route('instructeurs.voertuigen.beschikbaar', $instructeur) }}">Toevoegen voertuig</a>
            @endif
        </div>
    </section>

    <div class="table-responsive bg-white border rounded-3">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Type voertuig</th>
                    <th>Type</th>
                    <th>Kenteken</th>
                    <th>Bouwjaar</th>
                    <th>Brandstof</th>
                    <th>Rijbewijscategorie</th>
                    @if (auth()->user()->canManageVehicles())
                        <th>Wijzigen</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @forelse ($voertuigen as $voertuig)
                    <tr>
                        <td>{{ $voertuig->TypeVoertuig }}</td>
                        <td>{{ $voertuig->Type }}</td>
                        <td>{{ $voertuig->Kenteken }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($voertuig->Bouwjaar)->format('d-m-Y') }}</td>
                        <td>{{ $voertuig->Brandstof }}</td>
                        <td>{{ $voertuig->Rijbewijscategorie }}</td>
                        @if (auth()->user()->canManageVehicles())
                            <td>
                                <a class="btn btn-outline-secondary btn-sm" href="{{ route('instructeurs.voertuigen.edit', [$instructeur, $voertuig->Id]) }}" title="Wijzigen" aria-label="Wijzigen">
                                    &#9998;
                                </a>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Geen voertuigen toegewezen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
