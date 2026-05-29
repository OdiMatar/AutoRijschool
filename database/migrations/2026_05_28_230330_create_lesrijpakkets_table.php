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
        Schema::create('lesrijpakkets', function (Blueprint $table) {
            $table->id();
            $table->string('Naam', 80);
            $table->text('Beschrijving')->nullable();
            $table->decimal('Prijs', 10, 2);
            $table->integer('Lessen');
            $table->string('Categorie', 80)->nullable();
            $table->boolean('IsActief')->default(1);
            $table->string('Opmerking', 255)->nullable();
            $table->timestamp('DatumAangemaakt')->nullable();
            $table->timestamp('DatumGewijzigd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesrijpakkets');
    }
};
