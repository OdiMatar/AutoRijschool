<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Account extends Model
{
    protected $table = 'users';

    public static function allViaStoredProcedure(): Collection
    {
        return self::query()
            ->select(['id', 'name', 'email', 'role', 'created_at'])
            ->orderByDesc('created_at')
            ->get();
    }
}
