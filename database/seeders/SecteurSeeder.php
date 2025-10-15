<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\secteur;

class SecteurSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $secteurs = [
             [
                 'sigle' => 'M',
                 'libelle' => 'Maternelle',
             ],
             [
                 'sigle' => 'P',
                 'libelle' => 'Primaire',
             ],
             [
                 'sigle' => 'S',
                 'libelle' => 'Secondaire',
             ],
             [
                 'sigle' => 'U',
                 'libelle' => 'Universitaire',
             ],
             
        ];

        foreach ($secteurs as $e) {
            secteur::updateOrInsert([
                'sigle' => $e['sigle'],
                'libelle' => $e['libelle'],
            ]);
        }
    }
}
