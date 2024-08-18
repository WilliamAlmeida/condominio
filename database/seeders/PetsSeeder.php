<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = \App\Models\Tenant::first();

        if($tenant) {
            $morador = $tenant->moradores()->first();

            $tenant->pets()->create([
                'proprietario_id' => $morador->id,
                'nome' => 'Pingo',
                'raca' => 'Vira-lata',
                'cor' => 'Caramelo',
                'porte' => 'medio',
            ]);

            $morador = $tenant->moradores()->orderBy('id', 'desc')->first();

            $tenant->pets()->create([
                'proprietario_id' => $morador->id,
                'nome' => 'Théo',
                'raca' => 'Iorkshire',
                'cor' => 'Branco',
                'porte' => 'pequeno',
            ]);
        }
    }
}
