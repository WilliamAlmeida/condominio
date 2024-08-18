<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImoveisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = \App\Models\Tenant::first();

        if($tenant) {
            $bloco = $tenant->blocos()->inRandomOrder()->first();

            $morador = $tenant->moradores()->first();

            $imovel = $tenant->imoveis()->create([
                'bloco_id' => $bloco->id,
                'tipo' => 'apartamento',
                'andar' => '1',
                'rua' => null,
                'numero' => '1',
                'proprietario_id' => $morador->id,
            ]);

            $bloco = $tenant->blocos()->inRandomOrder()->first();

            $morador = $tenant->moradores()->orderBy('id', 'desc')->first();

            $imovel->moradores()->attach($morador->id);

            $tenant->imoveis()->create([
                'bloco_id' => $bloco->id,
                'tipo' => 'casa',
                'andar' => null,
                'rua' => 'Rua Dr Laércio Lincoln Figueira',
                'numero' => 'D19',
                'proprietario_id' => $morador->id,
            ]);
        }
    }
}
