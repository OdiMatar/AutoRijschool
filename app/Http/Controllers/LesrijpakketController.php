<?php

namespace App\Http\Controllers;

use App\Models\Lesrijpakket;
use Illuminate\View\View;

class LesrijpakketController extends Controller
{
    public function index(): View
    {
        $lesrijpakketten = Lesrijpakket::query()
            ->where('IsActief', 1)
            ->orderBy('Naam')
            ->get();

        return view('lesrijpakketten.index', [
            'lesrijpakketten' => $lesrijpakketten,
        ]);
    }
}
