<x-layout title="Door instructeur gebruikte voertuigen">
    <section class="app-page-heading d-flex justify-content-between align-items-start">
        <div>
            <p class="app-page-kicker">Voertuigtoewijzing</p>
            <h1>Door instructeur gebruikte voertuigen</h1>
            <div class="text-muted">
                <p class="mb-1">Naam: [{{ $instructeur->VolledigeNaam }}]</p>
                <p class="mb-1">Datum in dienst: [{{ $instructeur->DatumInDienst->format('d-m-Y') }}]</p>
                <p class="mb-0">Aantal sterren: [{{ $instructeur->AantalSterren }}]</p>
            </div>
            @if (auth()->user()->canManageVehicles() && $instructeur->IsActief)
                <a class="btn btn-primary mt-3" href="{{ route('instructeurs.voertuigen.beschikbaar', $instructeur) }}">Toevoegen voertuig</a>
            @endif
        </div>
    </section>

    <div class="vehicle-table-card">
        <div class="table-responsive">
        <table class="table vehicle-table align-middle mb-0">
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
                        <th>Verwijderen</th>
                        <th>Toegewezen</th>
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
                            <td>
                                <form method="post" action="{{ route('instructeurs.voertuigen.destroy', [$instructeur, $voertuig->Id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm" type="submit" title="Verwijderen" aria-label="Verwijderen">x</button>
                                </form>
                            </td>
                            <td>
                                @if ((int) $voertuig->IsToegewezen === 1)
                                    <span class="assignment-status assignment-status-ok" title="Toegewezen aan deze instructeur">&#10003;</span>
                                @else
                                    <form method="post" action="{{ route('instructeurs.voertuigen.restore', [$instructeur, $voertuig->Id]) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="assignment-status assignment-status-missing" type="submit" title="Opnieuw toewijzen aan {{ $instructeur->VolledigeNaam }}" aria-label="Opnieuw toewijzen aan {{ $instructeur->VolledigeNaam }}">
                                            &times;
                                        </button>
                                    </form>
                                @endif
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->canManageVehicles() ? 9 : 6 }}">Geen voertuigen toegewezen.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
</x-layout>
