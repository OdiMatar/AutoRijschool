<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LesrijpakketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('lesrijpakketten')->insert([
            [
                'Naam' => 'Basis Pakket',
                'Beschrijving' => 'Perfecte start voor beginners. Dit pakket bevat de fundamentele rijlessen voor leerlingrijders.',
                'Prijs' => 549.99,
                'Lessen' => 10,
                'Categorie' => 'Beginners',
                'IsActief' => 1,
                'Opmerking' => 'Populair startpakket',
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ],
            [
                'Naam' => 'Standaard Pakket',
                'Beschrijving' => 'Het meest gekozen pakket met een goede balans tussen aantal lessen en prijs.',
                'Prijs' => 999.99,
                'Lessen' => 20,
                'Categorie' => 'Standaard',
                'IsActief' => 1,
                'Opmerking' => 'Best-seller pakket',
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ],
            [
                'Naam' => 'Premium Pakket',
                'Beschrijving' => 'Uitgebreide training met extra oefentijd op het verkeerspark en snelwegtraining.',
                'Prijs' => 1699.99,
                'Lessen' => 35,
                'Categorie' => 'Premium',
                'IsActief' => 1,
                'Opmerking' => 'Inclusief snelwegtraining',
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ],
            [
                'Naam' => 'Intensief Pakket',
                'Beschrijving' => 'Voor cursisten die snel willen slagen. Meerdere lessen per week met intensieve begeleiding.',
                'Prijs' => 2299.99,
                'Lessen' => 50,
                'Categorie' => 'Intensief',
                'IsActief' => 1,
                'Opmerking' => 'Flexibele inplanning',
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ],
            [
                'Naam' => 'Extra Lessen',
                'Beschrijving' => 'Enkele extra rijlessen voor cursisten die meer oefening nodig hebben.',
                'Prijs' => 59.99,
                'Lessen' => 1,
                'Categorie' => 'Extra',
                'IsActief' => 1,
                'Opmerking' => 'Losse lessen',
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ],
        ]);
    }
}
