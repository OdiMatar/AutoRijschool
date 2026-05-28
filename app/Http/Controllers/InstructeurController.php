<?php

namespace App\Http\Controllers;

use App\Models\Instructeur;
use Illuminate\View\View;

class InstructeurController extends Controller
{
    public function index(): View
    {
        $instructeurs = Instructeur::query()
            ->where('IsActief', 1)
            ->orderBy('Achternaam')
            ->orderBy('Voornaam')
            ->get()
            ->sortByDesc(fn (Instructeur $instructeur) => strlen($instructeur->AantalSterren))
            ->values();

        $instructeurs->transform(function (Instructeur $instructeur) {
            $instructeur->VolledigeNaam = trim(
                $instructeur->Voornaam
                . ' '
                . ($instructeur->Tussenvoegsel ? $instructeur->Tussenvoegsel . ' ' : '')
                . $instructeur->Achternaam
            );

            return $instructeur;
        });

        return view('instructeurs.index', [
            'instructeurs' => $instructeurs,
        ]);
    }
}
