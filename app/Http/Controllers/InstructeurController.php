<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class InstructeurController extends Controller
{
    public function index()
    {
        return view('instructeurs.index', [
            'instructeurs' => DB::select('CALL sp_get_instructeurs_in_dienst()'),
        ]);
    }
}
