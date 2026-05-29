<?php

namespace App\Http\Controllers;

use App\Models\Lesrijpakket;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LesrijpakketController extends Controller
{
    public function index(Request $request): View
    {
        $geselecteerdeCategorie = trim((string) $request->query('categorie', ''));

        $query = Lesrijpakket::query()
            ->where('IsActief', 1)
            ->orderBy('Naam');

        if ($geselecteerdeCategorie !== '') {
            $query->where('Categorie', $geselecteerdeCategorie);
        }

        $lesrijpakketten = $query->get();
        $categorieen = Lesrijpakket::query()
            ->where('IsActief', 1)
            ->whereNotNull('Categorie')
            ->select('Categorie')
            ->distinct()
            ->orderBy('Categorie')
            ->pluck('Categorie')
            ->values()
            ->all();

        if (! in_array('Theorie', $categorieen, true)) {
            $categorieen[] = 'Theorie';
            sort($categorieen);
        }

        return view('lesrijpakketten.index', [
            'lesrijpakketten' => $lesrijpakketten,
            'categorieen' => $categorieen,
            'geselecteerdeCategorie' => $geselecteerdeCategorie,
        ]);
    }
}
