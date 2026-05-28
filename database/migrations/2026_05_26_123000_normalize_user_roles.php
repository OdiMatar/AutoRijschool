<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('users')
            ->whereIn('role', ['admin', 'owner'])
            ->update(['role' => 'administrator']);
    }

    public function down(): void
    {
        // Intentionally left blank: previous roles cannot be inferred safely.
    }
};
