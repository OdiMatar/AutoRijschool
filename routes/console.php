<?php

use App\Models\User;
use Database\Seeders\AccountSeeder;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('accounts:reset', function () {
    DB::statement('SET FOREIGN_KEY_CHECKS=0');
    User::query()->truncate();
    DB::statement('SET FOREIGN_KEY_CHECKS=1');

    $this->call('db:seed', ['--class' => AccountSeeder::class, '--force' => true]);
    $this->info('Accounts zijn verwijderd en opnieuw aangemaakt.');
})->purpose('Verwijder alle accounts en seed standaard accounts opnieuw');
