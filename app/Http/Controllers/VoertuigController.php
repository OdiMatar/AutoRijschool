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
        $voertuigen = DB::table('voertuigen as v')
            ->select([
                'v.Id',
                'v.Kenteken',
                'v.Type',
                'v.Bouwjaar',
                'v.Brandstof',
                'tv.TypeVoertuig',
                'tv.Rijbewijscategorie',
                'vi.DatumToekenning',
            ])
            ->join('voertuig_instructeur as vi', 'vi.VoertuigId', 'v.Id')
            ->join('type_voertuigen as tv', 'tv.Id', 'v.TypeVoertuigId')
            ->where('vi.InstructeurId', $instructeur->Id)
            ->where('v.IsActief', 1)
            ->where('vi.IsActief', 1)
            ->orderBy('tv.Rijbewijscategorie')
            ->orderBy('v.Type')
            ->get();

        return view('voertuigen.index', [
            'instructeur' => $instructeur,
            'voertuigen' => $voertuigen,
        ]);
    }

    public function beschikbaar(Instructeur $instructeur)
    {
        $voertuigen = DB::table('voertuigen as v')
            ->select([
                'v.Id',
                'v.Kenteken',
                'v.Type',
                'v.Bouwjaar',
                'v.Brandstof',
                'tv.TypeVoertuig',
                'tv.Rijbewijscategorie',
            ])
            ->join('type_voertuigen as tv', 'tv.Id', 'v.TypeVoertuigId')
            ->leftJoin('voertuig_instructeur as vi', 'vi.VoertuigId', 'v.Id')
            ->whereNull('vi.Id')
            ->where('v.IsActief', 1)
            ->orderBy('tv.Rijbewijscategorie')
            ->orderBy('v.Type')
            ->get();

        return view('voertuigen.beschikbaar', [
            'instructeur' => $instructeur,
            'voertuigen' => $voertuigen,
        ]);
    }

    public function edit(Instructeur $instructeur, Voertuig $voertuig)
    {
        $details = DB::table('voertuigen as v')
            ->select([
                'v.Id',
                'v.Kenteken',
                'v.Type',
                'v.Bouwjaar',
                'v.Brandstof',
                'v.TypeVoertuigId',
                'vi.InstructeurId',
            ])
            ->leftJoin('voertuig_instructeur as vi', 'vi.VoertuigId', 'v.Id')
            ->where('v.Id', $voertuig->Id)
            ->first();

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

        DB::transaction(function () use ($voertuig, $data, $request) {
            DB::table('voertuigen')
                ->where('Id', $voertuig->Id)
                ->update([
                    'Kenteken' => $data['Kenteken'],
                    'Type' => $data['Type'],
                    'Brandstof' => $data['Brandstof'],
                    'TypeVoertuigId' => $data['TypeVoertuigId'],
                    'DatumGewijzigd' => now(),
                ]);

            $existing = DB::table('voertuig_instructeur')
                ->where('VoertuigId', $voertuig->Id)
                ->first();

            if ($existing) {
                DB::table('voertuig_instructeur')
                    ->where('Id', $existing->Id)
                    ->update([
                        'InstructeurId' => $data['InstructeurId'],
                        'IsActief' => 1,
                        'DatumGewijzigd' => now(),
                    ]);
            } else {
                DB::table('voertuig_instructeur')->insert([
                    'VoertuigId' => $voertuig->Id,
                    'InstructeurId' => $data['InstructeurId'],
                    'DatumToekenning' => now()->toDateString(),
                    'IsActief' => 1,
                    'DatumAangemaakt' => now(),
                    'DatumGewijzigd' => now(),
                ]);
            }
        });

        return redirect()
            ->route('instructeurs.voertuigen.index', $instructeur)
            ->with('success', 'De voertuiggegevens zijn gewijzigd.');
    }
}
