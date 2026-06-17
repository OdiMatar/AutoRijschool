<x-layout title="Instructeurs in dienst">
    <section class="app-page-heading d-flex justify-content-between align-items-center">
        <div>
            <p class="app-page-kicker">Planning en inzetbaarheid</p>
            <h1>Instructeurs in dienst</h1>
            <p class="text-muted mb-0">Aantal instructeurs: [{{ count($instructeurs) }}]</p>
        </div>
    </section>

    <div class="vehicle-table-card">
        <div class="table-responsive">
            <table class="table vehicle-table align-middle mb-0">
                <thead>
                    <tr>
                        <th>Voornaam</th>
                        <th>Tussenvoegsel</th>
                        <th>Achternaam</th>
                        <th>Mobiel</th>
                        <th>Datum in dienst</th>
                        <th>Aantal sterren</th>
                        <th>Voertuigen</th>
                        @if (auth()->user()->canManageVehicles())
                            <th>Ziekte/Verlof</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($instructeurs as $instructeur)
                        <tr @class(['table-warning' => ! $instructeur->IsActief])>
                            <td class="fw-semibold">{{ $instructeur->Voornaam }}</td>
                            <td>{{ $instructeur->Tussenvoegsel ?? '-' }}</td>
                            <td>{{ $instructeur->Achternaam }}</td>
                            <td>{{ $instructeur->Mobiel }}</td>
                            <td>{{ \Illuminate\Support\Carbon::parse($instructeur->DatumInDienst)->format('d-m-Y') }}</td>
                            <td><span class="stars-cell">{{ $instructeur->AantalSterren }}</span></td>
                            <td>
                                <a class="btn btn-outline-primary btn-sm app-icon-button" href="{{ route('instructeurs.voertuigen.index', $instructeur->Id) }}" title="Voertuigen bekijken" aria-label="Voertuigen bekijken">
                                    &#128663;
                                </a>
                            </td>
                            @if (auth()->user()->canManageVehicles())
                                <td>
                                    <form method="post" action="{{ route('instructeurs.ziekte-verlof', $instructeur) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button
                                            class="btn btn-sm app-icon-button {{ $instructeur->IsActief ? 'btn-outline-success' : 'btn-outline-warning' }}"
                                            type="submit"
                                            title="{{ $instructeur->IsActief ? 'Ziek/met verlof melden' : 'Beter/terug melden' }}"
                                            aria-label="{{ $instructeur->IsActief ? 'Ziek/met verlof melden' : 'Beter/terug melden' }}"
                                        >
                                            {!! $instructeur->IsActief ? '&#128077;' : '&#129657;' !!}
                                        </button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
