<?php

namespace Database\Seeders;

 use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\niveau;

class NiveauSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // for ($i = 1; $i < 20; $i++) {
        //     DB::table('niveau')->insert(['id' => $i,'libelle' => 'Niveau '.$i]);

          
        // }

    //    niveau::create([
    //         'id' => 1,
    //         'libelle' => 'niveau 1'            
    //     ]);

    DB::table('niveaus')->insert(['id' => 1,'libelle' => 'Niveau 1']);

    }
}
