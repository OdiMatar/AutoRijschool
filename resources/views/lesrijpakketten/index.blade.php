<x-layout title="Lesrijpakketten Overzicht">
    <section class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1">Lesrijpakketten Overzicht</h1>
            <p class="text-muted mb-0">Aantal beschikbare pakketten: [{{ count($lesrijpakketten) }}]</p>
        </div>
    </section>

    <div class="bg-white border rounded-3 p-3 mb-3">
        <form method="get" action="{{ route('lesrijpakketten.index') }}" class="row g-2 align-items-end">
            <div class="col-md-9">
                <label for="categorie" class="form-label mb-1">Categorie</label>
                <select id="categorie" name="categorie" class="form-select">
                    <option value="">Alle categorieen</option>
                    @foreach ($categorieen as $categorie)
                        <option value="{{ $categorie }}" @selected($geselecteerdeCategorie === $categorie)>{{ $categorie }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3 d-grid">
                <button type="submit" class="btn btn-primary">Toon Lespakketten</button>
            </div>
        </form>
    </div>

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
                    <tr
                        role="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#pakket-{{ $pakket->id }}"
                        aria-expanded="false"
                        aria-controls="pakket-{{ $pakket->id }}"
                        style="cursor: pointer;"
                    >
                        <td class="fw-bold">{{ $pakket->Naam }}</td>
                        <td>{{ $pakket->Lessen }} lessen</td>
                        <td class="text-success fw-bold">EUR {{ number_format($pakket->Prijs, 2, ',', '.') }}</td>
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
                    <tr class="collapse bg-light" id="pakket-{{ $pakket->id }}">
                        <td colspan="5">
                            <div class="p-3">
                                <h2 class="h6 mb-2">Meer informatie over {{ $pakket->Naam }}</h2>
                                <p class="mb-2">
                                    <strong>Volledige beschrijving:</strong>
                                    {{ $pakket->Beschrijving ?: 'Geen beschrijving beschikbaar.' }}
                                </p>
                                <p class="mb-0">
                                    <strong>Opmerking:</strong>
                                    {{ $pakket->Opmerking ?: 'Geen extra opmerkingen.' }}
                                </p>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-4">
                            @if ($geselecteerdeCategorie === 'Theorie')
                                Er zijn geen lespakketten bekend die behoren bij de geselecteerde categorie
                            @else
                                Geen lespakketten beschikbaar
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-layout>
