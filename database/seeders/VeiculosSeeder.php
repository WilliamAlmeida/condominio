<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VeiculosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = \App\Models\Tenant::first();

        if($tenant) {
            $tenant->veiculos()->create([
                'placa' => 'ABC1234',
                'marca' => 'Fiat',
                'modelo' => 'Uno',
                'cor' => 'Vermelho',
                'ano' => '2010',
            ]);

            $tenant->veiculos()->create([
                'placa' => 'DEF5678',
                'marca' => 'Chevrolet',
                'modelo' => 'Celta',
                'cor' => 'Preto',
                'ano' => '2015',
            ]);

            $tenant->veiculos()->create([
                'placa' => 'GHI9012',
                'marca' => 'Ford',
                'modelo' => 'Ka',
                'cor' => 'Branco',
                'ano' => '2018',
            ]);
        }
    }
}
