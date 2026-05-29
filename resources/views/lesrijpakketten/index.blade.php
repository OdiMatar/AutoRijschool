<x-layout title="Lesrijpakketten Overzicht">
    <section class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Lesrijpakketten Overzicht</h1>
            <p class="text-muted mb-0">Aantal beschikbare pakketten: [{{ count($lesrijpakketten) }}]</p>
        </div>
    </section>

    <div class="table-responsive bg-white border rounded-3">
        <table class="table table-striped table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Aantal Lessen</th>
                    <th>Prijs</th>
                    <th>Categorie</th>
                    <th>Beschrijving</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($lesrijpakketten as $pakket)
                    <tr>
                        <td class="fw-bold">{{ $pakket->Naam }}</td>
                        <td>{{ $pakket->Lessen }} lessen</td>
                        <td class="text-success fw-bold">€ {{ number_format($pakket->Prijs, 2, ',', '.') }}</td>
                        <td>
                            @if ($pakket->Categorie)
                                <span class="badge bg-info">{{ $pakket->Categorie }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if ($pakket->Beschrijving)
                                <small class="text-muted">{{ substr($pakket->Beschrijving, 0, 50) }}@if (strlen($pakket->Beschrijving) > 50)...@endif</small>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            Geen lespakketten beschikbaar
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
