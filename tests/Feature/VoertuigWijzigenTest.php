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

    public function test_voertuiggegevens_worden_gewijzigd(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->put(route('instructeurs.voertuigen.update', [5, 10]), [
                'Kenteken' => 'DRS-52-E',
                'Type' => 'Vespa Piaggio',
                'Brandstof' => 'Elektrisch',
                'TypeVoertuigId' => 4,
                'InstructeurId' => 5,
            ])
            ->assertRedirect(route('instructeurs.voertuigen.index', 5));

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
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)
            ->put(route('instructeurs.voertuigen.update', [5, 10]), [
                'Kenteken' => 'DRS-52-P',
                'Type' => 'Vespa',
                'Brandstof' => 'Benzine',
                'TypeVoertuigId' => 4,
                'InstructeurId' => 4,
            ])
            ->assertRedirect(route('instructeurs.voertuigen.index', 5));

        $voertuigenVanMohammed = collect(DB::table('voertuig_instructeur')
            ->where('InstructeurId', 5)
            ->pluck('VoertuigId'));

        $this->assertFalse($voertuigenVanMohammed->contains(10));
        $this->assertDatabaseHas('voertuig_instructeur', [
            'VoertuigId' => 10,
            'InstructeurId' => 4,
        ]);
    }

    public function test_beschikbaar_voertuig_wordt_toegewezen_zonder_bouwjaar_te_wijzigen(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $bouwjaar = Voertuig::findOrFail(11)->Bouwjaar->format('Y-m-d');

        $this->actingAs($user)
            ->put(route('instructeurs.voertuigen.update', [5, 11]), [
                'Kenteken' => 'STP-12-U',
                'Type' => 'Kymco',
                'Brandstof' => 'Elektrisch',
                'TypeVoertuigId' => 4,
                'InstructeurId' => 5,
            ])
            ->assertRedirect(route('instructeurs.voertuigen.index', 5));

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
