<?php

namespace App\Http\Controllers;

use App\Models\Instructeur;
use App\Models\TypeVoertuig;
use App\Models\Voertuig;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class VoertuigController extends Controller
{
    public function index(Instructeur $instructeur)
    {
        return view('voertuigen.index', [
            'instructeur' => $instructeur,
            'voertuigen' => DB::select('CALL sp_get_voertuigen_bij_instructeur(?)', [$instructeur->Id]),
        ]);
    }

    public function beschikbaar(Instructeur $instructeur)
    {
        return view('voertuigen.beschikbaar', [
            'instructeur' => $instructeur,
            'voertuigen' => DB::select('CALL sp_get_beschikbare_voertuigen()'),
        ]);
    }

    public function edit(Instructeur $instructeur, Voertuig $voertuig)
    {
        $details = DB::selectOne('CALL sp_get_voertuig_edit(?)', [$voertuig->Id]);

        abort_if($details === null, 404);

        return view('voertuigen.edit', [
            'instructeur' => $instructeur,
            'voertuig' => $details,
            'instructeurs' => Instructeur::query()->orderBy('Voornaam')->orderBy('Achternaam')->get(),
            'typeVoertuigen' => TypeVoertuig::query()->orderBy('Rijbewijscategorie')->get(),
            'brandstoffen' => ['Benzine', 'Diesel', 'Elektrisch'],
        ]);
    }

    public function update(Request $request, Instructeur $instructeur, Voertuig $voertuig): RedirectResponse
    {
        $data = $request->validate([
            'Kenteken' => ['required', 'string', 'max:10', Rule::unique('voertuigen', 'Kenteken')->ignore($voertuig->Id, 'Id')],
            'Type' => ['required', 'string', 'max:80'],
            'Brandstof' => ['required', Rule::in(['Benzine', 'Diesel', 'Elektrisch'])],
            'TypeVoertuigId' => ['required', 'exists:type_voertuigen,Id'],
            'InstructeurId' => ['required', 'exists:instructeurs,Id'],
        ]);

        DB::statement('CALL sp_update_voertuig(?, ?, ?, ?, ?, ?, ?)', [
            $instructeur->Id,
            $voertuig->Id,
            $data['Kenteken'],
            $data['Type'],
            $data['Brandstof'],
            $data['TypeVoertuigId'],
            $data['InstructeurId'],
        ]);

        return redirect()
            ->route('instructeurs.voertuigen.index', $instructeur)
            ->with('success', 'De voertuiggegevens zijn gewijzigd.');
    }
}
