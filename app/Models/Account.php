<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class Account extends Model
{
    protected $table = 'users';

    public static function allViaStoredProcedure(): Collection
    {
        return collect(DB::select('CALL sp_get_accounts_overzicht()'));
    }
}
