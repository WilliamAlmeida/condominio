<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlocosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = \App\Models\Tenant::first();

        if($tenant) {
            $tenant->blocos()->create([
                'nome' => 'Bloco A',
            ]);

            $tenant->blocos()->create([
                'nome' => 'Bloco B',
            ]);

            $tenant->blocos()->create([
                'nome' => 'Bloco C',
            ]);
        }
    }
}
