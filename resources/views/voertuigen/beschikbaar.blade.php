<x-layout title="Alle beschikbare voertuigen">
    <section class="d-flex justify-content-between align-items-start mb-3">
        <div>
            <h1 class="h3 mb-2">Alle beschikbare voertuigen</h1>
            <div class="text-muted">
                <p class="mb-1">Naam: [{{ $instructeur->VolledigeNaam }}]</p>
                <p class="mb-1">Datum in dienst: [{{ $instructeur->DatumInDienst->format('d-m-Y') }}]</p>
                <p class="mb-0">Aantal sterren: [{{ $instructeur->AantalSterren }}]</p>
            </div>
        </div>
        <a class="btn btn-secondary" href="{{ route('instructeurs.voertuigen.index', $instructeur) }}">Terug</a>
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
                    <th>Toevoegen</th>
                    <th>Wijzigen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($voertuigen as $voertuig)
                    <tr>
                        <td>{{ $voertuig->TypeVoertuig }}</td>
                        <td>{{ $voertuig->Type }}</td>
                        <td>{{ $voertuig->Kenteken }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($voertuig->Bouwjaar)->format('d-m-Y') }}</td>
                        <td>{{ $voertuig->Brandstof }}</td>
                        <td>{{ $voertuig->Rijbewijscategorie }}</td>
                        <td>
                            <a class="btn btn-outline-primary btn-sm" href="{{ route('instructeurs.voertuigen.edit', [$instructeur, $voertuig->Id]) }}" title="Toevoegen" aria-label="Toevoegen">
                                +
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('instructeurs.voertuigen.edit', [$instructeur, $voertuig->Id]) }}" title="Wijzigen" aria-label="Wijzigen">
                                &#9998;
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
