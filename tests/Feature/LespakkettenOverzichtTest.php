<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class LespakkettenOverzichtTest extends TestCase
{
    use DatabaseTransactions;

    public function test_scenario_01_ik_kan_een_overzicht_zien_van_alle_lespakketten(): void
    {
        $user = User::factory()->create(['role' => 'administrator']);

        DB::table('lesrijpakkets')->insert([
            [
                'Naam' => 'Basis Pakket',
                'Beschrijving' => 'Startpakket voor beginners',
                'Prijs' => 549.99,
                'Lessen' => 10,
                'Categorie' => 'Beginners',
                'IsActief' => 1,
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ],
            [
                'Naam' => 'Premium Pakket',
                'Beschrijving' => 'Uitgebreid pakket',
                'Prijs' => 1699.99,
                'Lessen' => 35,
                'Categorie' => 'Premium',
                'IsActief' => 1,
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ],
        ]);

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Lespakketten Overzicht');

        $this->actingAs($user)
            ->get(route('lesrijpakketten.index'))
            ->assertOk()
            ->assertSee('Lesrijpakketten Overzicht')
            ->assertSee('Basis Pakket')
            ->assertSee('Premium Pakket');
    }

    public function test_scenario_02_geen_overzicht_bij_categorie_theorie(): void
    {
        $user = User::factory()->create(['role' => 'administrator']);

        DB::table('lesrijpakkets')->insert([
            [
                'Naam' => 'Standaard Pakket',
                'Beschrijving' => 'Meest gekozen pakket',
                'Prijs' => 999.99,
                'Lessen' => 20,
                'Categorie' => 'Standaard',
                'IsActief' => 1,
                'DatumAangemaakt' => now(),
                'DatumGewijzigd' => now(),
            ],
        ]);

        $this->actingAs($user)
            ->get(route('lesrijpakketten.index', [
                'categorie' => 'Theorie',
            ]))
            ->assertOk()
            ->assertSee('Er zijn geen lespakketten bekend die behoren bij de geselecteerde categorie');
    }
}
