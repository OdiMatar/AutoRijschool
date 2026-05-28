<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Voertuig;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class VoertuigWijzigenTest extends TestCase
{
    use DatabaseTransactions;

    public function test_voertuiggegevens_worden_gewijzigd_via_stored_procedure(): void
    {
        DB::statement('CALL sp_update_voertuig(?, ?, ?, ?, ?, ?, ?)', [
            5,
            10,
            'DRS-52-E',
            'Vespa Piaggio',
            'Elektrisch',
            4,
            5,
        ]);

        $this->assertDatabaseHas('voertuigen', [
            'Id' => 10,
            'Kenteken' => 'DRS-52-E',
            'Type' => 'Vespa Piaggio',
            'Brandstof' => 'Elektrisch',
            'Bouwjaar' => '2022-03-21',
        ]);
    }

    public function test_voertuig_kan_naar_andere_instructeur_worden_verplaatst(): void
    {
        DB::statement('CALL sp_update_voertuig(?, ?, ?, ?, ?, ?, ?)', [
            5,
            10,
            'DRS-52-P',
            'Vespa',
            'Benzine',
            4,
            4,
        ]);

        $voertuigenVanMohammed = collect(DB::select('CALL sp_get_voertuigen_bij_instructeur(?)', [5]));

        $this->assertFalse($voertuigenVanMohammed->contains('Id', 10));
        $this->assertDatabaseHas('voertuig_instructeur', [
            'VoertuigId' => 10,
            'InstructeurId' => 4,
        ]);
    }

    public function test_beschikbaar_voertuig_wordt_toegewezen_zonder_bouwjaar_te_wijzigen(): void
    {
        $bouwjaar = Voertuig::findOrFail(11)->Bouwjaar->format('Y-m-d');

        DB::statement('CALL sp_update_voertuig(?, ?, ?, ?, ?, ?, ?)', [
            5,
            11,
            'STP-12-U',
            'Kymco',
            'Elektrisch',
            4,
            5,
        ]);

        $this->assertDatabaseHas('voertuigen', [
            'Id' => 11,
            'Brandstof' => 'Elektrisch',
            'Bouwjaar' => $bouwjaar,
        ]);

        $this->assertDatabaseHas('voertuig_instructeur', [
            'VoertuigId' => 11,
            'InstructeurId' => 5,
        ]);
    }

    public function test_instructeur_mag_wijzigpagina_niet_openen(): void
    {
        $user = User::factory()->create(['role' => 'instructeur']);

        $this->actingAs($user)
            ->get(route('instructeurs.voertuigen.edit', [5, 10]))
            ->assertForbidden();
    }

    public function test_admin_mag_wijzigpagina_openen(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->get(route('instructeurs.voertuigen.edit', [5, 10]))
            ->assertOk()
            ->assertSee('Wijzigen voertuiggegevens');
    }
}
