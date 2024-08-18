<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MoradoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = \App\Models\Tenant::first();

        if($tenant) {
            $tenant->moradores()->create([
                'nome' => 'William',
                'sobrenome' => 'Almeida',
                'rg' => null,
                'cpf' => '41754494854',
                'nascimento' => '1994-05-05',
                'telefone' => '12982184879',
                'whatsapp' => '12982184879',
                'email' => null,
            ]);

            $tenant->moradores()->create([
                'nome' => 'Stephany',
                'sobrenome' => 'Correa',
                'rg' => null,
                'cpf' => '43737386889',
                'nascimento' => '1991-12-27',
                'telefone' => null,
                'whatsapp' => null,
                'email' => null,
            ]);
        }
    }
}
