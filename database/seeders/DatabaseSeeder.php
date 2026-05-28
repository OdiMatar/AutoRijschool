<?php

namespace Database\Seeders;

use App\Models\Instructeur;
use App\Models\TypeVoertuig;
use App\Models\User;
use App\Models\Voertuig;
use App\Models\VoertuigInstructeur;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator Autorijschool',
            'email' => 'administrator@autorijschool.test',
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
            'email' => 'admin@autorijschool.test',
            'password' => 'password',
            'role' => 'administrator',
        ]);

        TypeVoertuig::insert([
            ['Id' => 1, 'TypeVoertuig' => 'Personenauto', 'Rijbewijscategorie' => 'B', 'IsActief' => true],
            ['Id' => 2, 'TypeVoertuig' => 'Vrachtwagen', 'Rijbewijscategorie' => 'C', 'IsActief' => true],
            ['Id' => 3, 'TypeVoertuig' => 'Bus', 'Rijbewijscategorie' => 'D', 'IsActief' => true],
            ['Id' => 4, 'TypeVoertuig' => 'Bromfiets', 'Rijbewijscategorie' => 'AM', 'IsActief' => true],
        ]);

        Voertuig::insert([
            ['Id' => 1, 'Kenteken' => 'AU-67-IO', 'Type' => 'Golf', 'Bouwjaar' => '2017-06-12', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 1, 'IsActief' => true],
            ['Id' => 2, 'Kenteken' => 'TR-24-OP', 'Type' => 'DAF', 'Bouwjaar' => '2019-05-23', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 2, 'IsActief' => true],
            ['Id' => 3, 'Kenteken' => 'TH-78-KL', 'Type' => 'Mercedes', 'Bouwjaar' => '2023-01-01', 'Brandstof' => 'Benzine', 'TypeVoertuigId' => 1, 'IsActief' => true],
            ['Id' => 4, 'Kenteken' => '90-KL-TR', 'Type' => 'Fiat 500', 'Bouwjaar' => '2021-09-12', 'Brandstof' => 'Benzine', 'TypeVoertuigId' => 1, 'IsActief' => true],
            ['Id' => 5, 'Kenteken' => '34-TK-LP', 'Type' => 'Scania', 'Bouwjaar' => '2015-03-13', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 2, 'IsActief' => true],
            ['Id' => 6, 'Kenteken' => 'YY-OP-78', 'Type' => 'BMW M5', 'Bouwjaar' => '2022-05-13', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 1, 'IsActief' => true],
            ['Id' => 7, 'Kenteken' => 'UU-HH-JK', 'Type' => 'M.A.N', 'Bouwjaar' => '2017-12-03', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 2, 'IsActief' => true],
            ['Id' => 8, 'Kenteken' => 'ST-FZ-28', 'Type' => 'Citroen', 'Bouwjaar' => '2018-01-20', 'Brandstof' => 'Elektrisch', 'TypeVoertuigId' => 1, 'IsActief' => true],
            ['Id' => 9, 'Kenteken' => '123-FR-T', 'Type' => 'Piaggio ZIP', 'Bouwjaar' => '2021-02-01', 'Brandstof' => 'Benzine', 'TypeVoertuigId' => 4, 'IsActief' => true],
            ['Id' => 10, 'Kenteken' => 'DRS-52-P', 'Type' => 'Vespa', 'Bouwjaar' => '2022-03-21', 'Brandstof' => 'Benzine', 'TypeVoertuigId' => 4, 'IsActief' => true],
            ['Id' => 11, 'Kenteken' => 'STP-12-U', 'Type' => 'Kymco', 'Bouwjaar' => '2022-07-02', 'Brandstof' => 'Benzine', 'TypeVoertuigId' => 4, 'IsActief' => true],
            ['Id' => 12, 'Kenteken' => '45-SD-23', 'Type' => 'Renault', 'Bouwjaar' => '2023-01-01', 'Brandstof' => 'Diesel', 'TypeVoertuigId' => 3, 'IsActief' => true],
        ]);

        Instructeur::insert([
            ['Id' => 1, 'Voornaam' => 'Li', 'Tussenvoegsel' => null, 'Achternaam' => 'Zhan', 'Mobiel' => '06-28493827', 'DatumInDienst' => '2015-04-17', 'AantalSterren' => '***', 'IsActief' => true],
            ['Id' => 2, 'Voornaam' => 'Leroy', 'Tussenvoegsel' => null, 'Achternaam' => 'Boerhaven', 'Mobiel' => '06-39398734', 'DatumInDienst' => '2018-06-25', 'AantalSterren' => '*', 'IsActief' => true],
            ['Id' => 3, 'Voornaam' => 'Yoeri', 'Tussenvoegsel' => 'Van', 'Achternaam' => 'Veen', 'Mobiel' => '06-24383291', 'DatumInDienst' => '2010-05-12', 'AantalSterren' => '***', 'IsActief' => true],
            ['Id' => 4, 'Voornaam' => 'Bert', 'Tussenvoegsel' => 'Van', 'Achternaam' => 'Sali', 'Mobiel' => '06-48293823', 'DatumInDienst' => '2023-01-10', 'AantalSterren' => '****', 'IsActief' => true],
            ['Id' => 5, 'Voornaam' => 'Mohammed', 'Tussenvoegsel' => 'El', 'Achternaam' => 'Yassidi', 'Mobiel' => '06-34291234', 'DatumInDienst' => '2010-06-14', 'AantalSterren' => '*****', 'IsActief' => true],
        ]);

        VoertuigInstructeur::insert([
            ['Id' => 1, 'VoertuigId' => 1, 'InstructeurId' => 5, 'DatumToekenning' => '2017-06-18', 'IsActief' => true],
            ['Id' => 2, 'VoertuigId' => 3, 'InstructeurId' => 1, 'DatumToekenning' => '2021-09-26', 'IsActief' => true],
            ['Id' => 3, 'VoertuigId' => 9, 'InstructeurId' => 1, 'DatumToekenning' => '2021-09-27', 'IsActief' => true],
            ['Id' => 4, 'VoertuigId' => 4, 'InstructeurId' => 4, 'DatumToekenning' => '2022-08-01', 'IsActief' => true],
            ['Id' => 5, 'VoertuigId' => 5, 'InstructeurId' => 1, 'DatumToekenning' => '2019-08-30', 'IsActief' => true],
            ['Id' => 6, 'VoertuigId' => 10, 'InstructeurId' => 5, 'DatumToekenning' => '2020-02-02', 'IsActief' => true],
            ['Id' => 7, 'VoertuigId' => 2, 'InstructeurId' => 5, 'DatumToekenning' => '2020-03-12', 'IsActief' => true],
        ]);
    }
}
