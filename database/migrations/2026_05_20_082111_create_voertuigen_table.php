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
        Schema::create('voertuigen', function (Blueprint $table) {
            $table->id('Id');
            $table->string('Kenteken', 10)->unique();
            $table->string('Type', 80);
            $table->date('Bouwjaar');
            $table->string('Brandstof', 20);
            $table->foreignId('TypeVoertuigId')->constrained('type_voertuigen', 'Id');
            $table->boolean('IsActief')->default(true);
            $table->string('Opmerking')->nullable();
            $table->timestamp('DatumAangemaakt')->nullable();
            $table->timestamp('DatumGewijzigd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voertuigen');
    }
};
