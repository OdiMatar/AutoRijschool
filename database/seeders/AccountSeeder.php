<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Seed the application's accounts.
     */
    public function run(): void
    {
        User::query()->delete();

        User::create([
            'name' => 'Administrator Autorijschool',
            'email' => 'admin@autorijschool.test',
            'password' => 'password',
            'role' => 'administrator',
        ]);

        User::create([
            'name' => 'Instructeur Demo',
            'email' => 'instructeur@autorijschool.test',
            'password' => 'password',
            'role' => 'instructeur',
        ]);

        User::create([
            'name' => 'Leerling Demo',
            'email' => 'leerling@autorijschool.test',
            'password' => 'password',
            'role' => 'leerling',
        ]);

        User::create([
            'name' => 'Administrator Backup',
            'email' => 'administrator@autorijschool.test',
            'password' => 'password',
            'role' => 'administrator',
        ]);
    }
}
