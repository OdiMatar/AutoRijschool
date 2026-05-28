<x-layout title="Wijzigen voertuiggegevens">
    <section class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-0">Wijzigen voertuiggegevens</h1>
        </div>
        <a class="btn btn-secondary" href="{{ route('instructeurs.voertuigen.index', $instructeur) }}">Terug</a>
    </section>

    <form class="card card-body border shadow-sm" method="post" action="{{ route('instructeurs.voertuigen.update', [$instructeur, $voertuig->Id]) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
        <label class="form-label">
            Instructeur:
            <select class="form-select" name="InstructeurId" required>
                @foreach ($instructeurs as $rijInstructeur)
                    <option value="{{ $rijInstructeur->Id }}" @selected((int) old('InstructeurId', $voertuig->InstructeurId ?? $instructeur->Id) === $rijInstructeur->Id)>
                        {{ $rijInstructeur->VolledigeNaam }}
                    </option>
                @endforeach
            </select>
        </label>
        </div>

        <div class="mb-3">
        <label class="form-label">
            Type voertuig:
            <select class="form-select" name="TypeVoertuigId" required>
                @foreach ($typeVoertuigen as $typeVoertuig)
                    <option value="{{ $typeVoertuig->Id }}" @selected((int) old('TypeVoertuigId', $voertuig->TypeVoertuigId) === $typeVoertuig->Id)>
                        {{ $typeVoertuig->TypeVoertuig }}
                    </option>
                @endforeach
            </select>
        </label>
        </div>

        <div class="mb-3">
        <label class="form-label">
            Type:
            <input class="form-control" name="Type" value="{{ old('Type', $voertuig->Type) }}" required>
            @error('Type')<span class="text-danger small">{{ $message }}</span>@enderror
        </label>
        </div>

        <div class="mb-3">
        <label class="form-label">
            Bouwjaar:
            <input class="form-control" value="{{ \Illuminate\Support\Carbon::parse($voertuig->Bouwjaar)->format('d-m-Y') }}" readonly>
        </label>
        </div>

        <fieldset class="mb-3">
            <legend class="col-form-label pt-0">Brandstof:</legend>
            @foreach ($brandstoffen as $brandstof)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="Brandstof" value="{{ $brandstof }}" @checked(old('Brandstof', $voertuig->Brandstof) === $brandstof) required>
                    <label class="form-check-label">{{ $brandstof }}</label>
                </div>
            @endforeach
            @error('Brandstof')<div><span class="text-danger small">{{ $message }}</span></div>@enderror
        </fieldset>

        <div class="mb-3">
        <label class="form-label">
            Kenteken:
            <input class="form-control" name="Kenteken" value="{{ old('Kenteken', $voertuig->Kenteken) }}" maxlength="10" required>
            @error('Kenteken')<span class="text-danger small">{{ $message }}</span>@enderror
        </label>
        </div>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary" type="submit">Wijzig</button>
        </div>
    </form>
</x-layout>
