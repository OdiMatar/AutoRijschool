<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use DatabaseTransactions;

    public function test_guest_wordt_naar_login_gestuurd(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/login');
    }

    public function test_ingelogde_gebruiker_ziet_homepagina(): void
    {
        $user = User::factory()->create(['role' => 'instructeur']);

        $this->actingAs($user)
            ->get('/')
            ->assertOk()
            ->assertSee('Welkom bij Autorijschool Rijvaardig');
    }
}
