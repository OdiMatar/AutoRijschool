<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\View\View;

class AccountController extends Controller
{
    public function index(): View
    {
        return view('accounts.index', [
            'accounts' => Account::allViaStoredProcedure(),
        ]);
    }
}
