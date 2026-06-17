<?php

namespace App\Http\Controllers;

use App\Models\Instructeur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class InstructeurController extends Controller
{
    public function index(): View
    {
        $instructeurs = Instructeur::query()
            ->orderBy('Achternaam')
            ->orderBy('Voornaam')
            ->get()
            ->sortByDesc(fn (Instructeur $instructeur) => strlen($instructeur->AantalSterren))
            ->values();

        $instructeurs->transform(function (Instructeur $instructeur) {
            $instructeur->VolledigeNaam = trim(
                $instructeur->Voornaam
                .' '
                .($instructeur->Tussenvoegsel ? $instructeur->Tussenvoegsel.' ' : '')
                .$instructeur->Achternaam
            );

            return $instructeur;
        });

        return view('instructeurs.index', [
            'instructeurs' => $instructeurs,
        ]);
    }

    public function toggleZiekteVerlof(Instructeur $instructeur): RedirectResponse
    {
        $naam = $instructeur->VolledigeNaam;
        $wordtZiekGemeld = $instructeur->IsActief;

        DB::transaction(function () use ($instructeur, $wordtZiekGemeld): void {
            if ($wordtZiekGemeld) {
                $instructeur->update(['IsActief' => 0]);

                DB::table('voertuig_instructeur')
                    ->where('InstructeurId', $instructeur->Id)
                    ->where('IsActief', 1)
                    ->update([
                        'IsActief' => 0,
                        'VerlofInstructeurId' => $instructeur->Id,
                        'VerlofAangemeldOp' => now(),
                        'DatumGewijzigd' => now(),
                    ]);

                return;
            }

            $instructeur->update(['IsActief' => 1]);

            DB::table('voertuig_instructeur')
                ->where('VerlofInstructeurId', $instructeur->Id)
                ->where('InstructeurId', $instructeur->Id)
                ->update([
                    'IsActief' => 1,
                    'VerlofInstructeurId' => null,
                    'VerlofAangemeldOp' => null,
                    'DatumGewijzigd' => now(),
                ]);
        });

        $melding = $wordtZiekGemeld
            ? "Instructeur {$naam} is ziek/met verlof gemeld"
            : "Instructeur {$naam} is beter/terug van verlof gemeld";

        Log::info('Ziekte/verlof status instructeur gewijzigd.', [
            'instructeur_id' => $instructeur->Id,
            'instructeur_naam' => $naam,
            'nieuw_actief' => ! $wordtZiekGemeld,
        ]);

        return redirect()
            ->route('instructeurs.index')
            ->with('success', $melding);
    }
}
