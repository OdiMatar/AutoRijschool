<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('voertuig_instructeur', function (Blueprint $table) {
            $table->id('Id');
            $table->foreignId('VoertuigId')->constrained('voertuigen', 'Id')->cascadeOnDelete();
            $table->foreignId('InstructeurId')->constrained('instructeurs', 'Id')->cascadeOnDelete();
            $table->date('DatumToekenning');
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking')->nullable();
            $table->timestamp('DatumAangemaakt')->nullable();
            $table->timestamp('DatumGewijzigd')->nullable();
            $table->unique('VoertuigId');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voertuig_instructeur');
    }
};
