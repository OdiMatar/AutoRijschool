<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_ziet_landingpagina(): void
    {
        $response = $this->get('/');

        $response->assertOk()
            ->assertSee('Rijschool Vierkante Wielen');
    }

    public function test_ingelogde_gebruiker_ziet_homepagina(): void
    {
        $user = User::factory()->create(['role' => 'instructeur']);

        $this->actingAs($user)
            ->get(route('home'))
            ->assertOk()
            ->assertSee('Welkom bij Rijschool Vierkante Wielen');
    }
}
