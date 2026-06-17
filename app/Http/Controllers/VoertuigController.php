<?php

namespace App\Http\Controllers;

use App\Models\Instructeur;
use App\Models\TypeVoertuig;
use App\Models\Voertuig;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class VoertuigController extends Controller
{
    public function alleVoertuigen(): View
    {
        return view('voertuigen.alles', [
            'voertuigen' => $this->alleVoertuigenQuery()->get()->map($this->withInstructeurNaam(...)),
        ]);
    }

    public function index(Instructeur $instructeur)
    {
        return view('voertuigen.index', [
            'instructeur' => $instructeur,
            'voertuigen' => DB::table('voertuigen as v')
                ->join('voertuig_instructeur as vi', 'vi.VoertuigId', '=', 'v.Id')
                ->join('type_voertuigen as tv', 'tv.Id', '=', 'v.TypeVoertuigId')
                ->when(
                    $instructeur->IsActief,
                    fn ($query) => $query->where(function ($query) use ($instructeur): void {
                        $query->where(function ($query) use ($instructeur): void {
                            $query->where('vi.InstructeurId', $instructeur->Id)
                                ->where('vi.IsActief', 1);
                        })->orWhere('vi.VerlofInstructeurId', $instructeur->Id);
                    }),
                    fn ($query) => $query->whereRaw('1 = 0')
                )
                ->where('v.IsActief', 1)
                ->orderByDesc('tv.Rijbewijscategorie')
                ->orderBy('v.Type')
                ->select([
                    'v.Id',
                    'v.Kenteken',
                    'v.Type',
                    'v.Bouwjaar',
                    'v.Brandstof',
                    'tv.TypeVoertuig',
                    'tv.Rijbewijscategorie',
                    'vi.DatumToekenning',
                    'vi.InstructeurId',
                    'vi.VerlofInstructeurId',
                    DB::raw("CASE WHEN vi.InstructeurId = {$instructeur->Id} AND vi.IsActief = 1 THEN 1 ELSE 0 END as IsToegewezen"),
                ])
                ->get(),
        ]);
    }

    public function beschikbaar(Instructeur $instructeur)
    {
        return view('voertuigen.beschikbaar', [
            'instructeur' => $instructeur,
            'voertuigen' => DB::table('voertuigen as v')
                ->join('type_voertuigen as tv', 'tv.Id', '=', 'v.TypeVoertuigId')
                ->leftJoin('voertuig_instructeur as vi', 'vi.VoertuigId', '=', 'v.Id')
                ->where(function ($query): void {
                    $query->whereNull('vi.Id')
                        ->orWhere('vi.IsActief', 0);
                })
                ->where('v.IsActief', 1)
                ->orderBy('tv.Rijbewijscategorie')
                ->orderBy('v.Type')
                ->select([
                    'v.Id',
                    'v.Kenteken',
                    'v.Type',
                    'v.Bouwjaar',
                    'v.Brandstof',
                    'tv.TypeVoertuig',
                    'tv.Rijbewijscategorie',
                ])
                ->get(),
        ]);
    }

    public function edit(Instructeur $instructeur, Voertuig $voertuig)
    {
        $details = DB::table('voertuigen as v')
            ->leftJoin('voertuig_instructeur as vi', 'vi.VoertuigId', '=', 'v.Id')
            ->where('v.Id', $voertuig->Id)
            ->select([
                'v.Id',
                'v.Kenteken',
                'v.Type',
                'v.Bouwjaar',
                'v.Brandstof',
                'v.TypeVoertuigId',
                'vi.InstructeurId',
            ])
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
            'InstructeurId' => [
                'required',
                Rule::exists('instructeurs', 'Id')->where(fn ($query) => $query->where('IsActief', 1)),
            ],
        ]);

        DB::transaction(function () use ($data, $voertuig): void {
            $voertuig->update([
                'Kenteken' => $data['Kenteken'],
                'Type' => $data['Type'],
                'Brandstof' => $data['Brandstof'],
                'TypeVoertuigId' => $data['TypeVoertuigId'],
            ]);

            $toewijzing = DB::table('voertuig_instructeur')
                ->where('VoertuigId', $voertuig->Id)
                ->first();

            if ($toewijzing) {
                DB::table('voertuig_instructeur')
                    ->where('VoertuigId', $voertuig->Id)
                    ->update([
                        'InstructeurId' => $data['InstructeurId'],
                        'IsActief' => 1,
                        'DatumGewijzigd' => now(),
                    ]);

                return;
            }

            DB::table('voertuig_instructeur')->insert([
                'VoertuigId' => $voertuig->Id,
                'InstructeurId' => $data['InstructeurId'],
                'DatumToekenning' => now()->toDateString(),
                'IsActief' => 1,
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ]);
        });

        return redirect()
            ->route('instructeurs.voertuigen.index', $instructeur)
            ->with('success', 'De voertuiggegevens zijn gewijzigd.');
    }

    public function destroyFromInstructor(Instructeur $instructeur, Voertuig $voertuig): View
    {
        DB::table('voertuig_instructeur')
            ->where('InstructeurId', $instructeur->Id)
            ->where('VoertuigId', $voertuig->Id)
            ->delete();

        return view('voertuigen.status', [
            'title' => 'Voertuig verwijderd',
            'message' => 'Het door u geselecteerde voertuig is verwijderd',
            'redirectUrl' => route('instructeurs.voertuigen.index', $instructeur),
        ]);
    }

    public function destroyFromAll(Voertuig $voertuig): View|RedirectResponse
    {
        $heeftActieveToewijzing = DB::table('voertuig_instructeur')
            ->where('VoertuigId', $voertuig->Id)
            ->where('IsActief', 1)
            ->exists();

        if (! $heeftActieveToewijzing) {
            return redirect()
                ->route('voertuigen.alles')
                ->with('error', 'Het door u geselecteerde voertuig staat op non actief en kan niet worden verwijderd');
        }

        DB::transaction(function () use ($voertuig): void {
            DB::table('voertuig_instructeur')
                ->where('VoertuigId', $voertuig->Id)
                ->delete();

            $voertuig->update(['IsActief' => 0]);
        });

        return view('voertuigen.status', [
            'title' => 'Voertuig verwijderd',
            'message' => 'Het door u geselecteerde voertuig is verwijderd',
            'redirectUrl' => route('voertuigen.alles'),
        ]);
    }

    public function restoreToInstructor(Instructeur $instructeur, Voertuig $voertuig): RedirectResponse
    {
        DB::table('voertuig_instructeur')
            ->where('VoertuigId', $voertuig->Id)
            ->where('VerlofInstructeurId', $instructeur->Id)
            ->update([
                'InstructeurId' => $instructeur->Id,
                'IsActief' => 1,
                'VerlofInstructeurId' => null,
                'VerlofAangemeldOp' => null,
                'DatumGewijzigd' => now(),
            ]);

        Log::info('Voertuig opnieuw toegewezen aan teruggekeerde instructeur.', [
            'instructeur_id' => $instructeur->Id,
            'voertuig_id' => $voertuig->Id,
        ]);

        return redirect()
            ->route('instructeurs.voertuigen.index', $instructeur)
            ->with('success', "Het geselecteerde voertuig is weer toegewezen aan {$instructeur->VolledigeNaam}");
    }

    private function alleVoertuigenQuery()
    {
        return DB::table('voertuigen as v')
            ->join('type_voertuigen as tv', 'tv.Id', '=', 'v.TypeVoertuigId')
            ->leftJoin('voertuig_instructeur as vi', function ($join): void {
                $join->on('vi.VoertuigId', '=', 'v.Id')
                    ->where('vi.IsActief', 1);
            })
            ->leftJoin('instructeurs as i', 'i.Id', '=', 'vi.InstructeurId')
            ->where('v.IsActief', 1)
            ->orderByDesc('v.Bouwjaar')
            ->orderByDesc('i.Achternaam')
            ->orderBy('v.Type')
            ->select([
                'v.Id',
                'v.Kenteken',
                'v.Type',
                'v.Bouwjaar',
                'v.Brandstof',
                'tv.TypeVoertuig',
                'tv.Rijbewijscategorie',
                'i.Voornaam as InstructeurVoornaam',
                'i.Tussenvoegsel as InstructeurTussenvoegsel',
                'i.Achternaam as InstructeurAchternaam',
                'vi.Id as ToewijzingId',
            ]);
    }

    private function withInstructeurNaam(object $voertuig): object
    {
        $voertuig->InstructeurNaam = trim(implode(' ', array_filter([
            $voertuig->InstructeurVoornaam,
            $voertuig->InstructeurTussenvoegsel,
            $voertuig->InstructeurAchternaam,
        ])));

        return $voertuig;
    }
}
