<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
DROP PROCEDURE IF EXISTS sp_get_accounts_overzicht;
CREATE PROCEDURE sp_get_accounts_overzicht()
BEGIN
    SELECT id, name, email, role, created_at
    FROM users
    ORDER BY created_at DESC;
END
SQL);
    }

    public function down(): void
    {
        DB::unprepared('DROP PROCEDURE IF EXISTS sp_get_accounts_overzicht');
    }
};
