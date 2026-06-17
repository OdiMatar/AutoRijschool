<x-layout title="Alle voertuigen">
    <section class="app-page-heading">
        <div>
            <p class="app-page-kicker">Voertuigenbeheer</p>
            <h1>Alle voertuigen</h1>
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
                    <th>Instructeur naam</th>
                    @if (auth()->user()->canManageVehicles())
                        <th>Verwijderen</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @forelse ($voertuigen as $voertuig)
                    <tr>
                        <td>
                            <span class="vehicle-type-pill">{{ $voertuig->TypeVoertuig }}</span>
                        </td>
                        <td class="fw-semibold">{{ $voertuig->Type }}</td>
                        <td><span class="vehicle-plate">{{ $voertuig->Kenteken }}</span></td>
                        <td>{{ \Illuminate\Support\Carbon::parse($voertuig->Bouwjaar)->format('d-m-Y') }}</td>
                        <td>{{ $voertuig->Brandstof }}</td>
                        <td><span class="vehicle-license-pill">{{ $voertuig->Rijbewijscategorie }}</span></td>
                        <td>{{ $voertuig->InstructeurNaam ?: '-' }}</td>
                        @if (auth()->user()->canManageVehicles())
                            <td class="text-end">
                                <form method="post" action="{{ route('voertuigen.destroy', $voertuig->Id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm vehicle-delete-button" type="submit" title="Verwijderen" aria-label="Verwijderen">
                                        &times;
                                    </button>
                                </form>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->canManageVehicles() ? 8 : 7 }}" class="text-center text-muted py-4">
                            Geen voertuigen gevonden.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layout>
