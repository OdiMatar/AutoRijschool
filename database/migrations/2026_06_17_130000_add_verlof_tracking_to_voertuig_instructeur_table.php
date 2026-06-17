<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('voertuig_instructeur', function (Blueprint $table): void {
            $table->foreignId('VerlofInstructeurId')
                ->nullable()
                ->after('InstructeurId')
                ->constrained('instructeurs', 'Id')
                ->nullOnDelete();
            $table->timestamp('VerlofAangemeldOp')->nullable()->after('VerlofInstructeurId');
        });
    }

    public function down(): void
    {
        Schema::table('voertuig_instructeur', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('VerlofInstructeurId');
            $table->dropColumn('VerlofAangemeldOp');
        });
    }
};
