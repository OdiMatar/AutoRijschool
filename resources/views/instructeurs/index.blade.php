<x-layout title="Instructeurs in dienst">
    <section class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Instructeurs in dienst</h1>
            <p class="text-muted mb-0">Aantal instructeurs: [{{ count($instructeurs) }}]</p>
        </div>
    </section>

    <div class="table-responsive bg-white border rounded-3">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Mobiel</th>
                    <th>Datum in dienst</th>
                    <th>Aantal sterren</th>
                    <th>Voertuigen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instructeurs as $instructeur)
                    <tr>
                        <td>{{ $instructeur->VolledigeNaam }}</td>
                        <td>{{ $instructeur->Mobiel }}</td>
                        <td>{{ \Illuminate\Support\Carbon::parse($instructeur->DatumInDienst)->format('d-m-Y') }}</td>
                        <td class="fw-bold text-warning-emphasis">{{ $instructeur->AantalSterren }}</td>
                        <td>
                            <a class="btn btn-outline-secondary btn-sm" href="{{ route('instructeurs.voertuigen.index', $instructeur->Id) }}" title="Voertuigen bekijken" aria-label="Voertuigen bekijken">
                                🛻
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
