<?php

namespace Database\Seeders;

use App\Models\Cidade;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PrestadoresServicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tenant = \App\Models\Tenant::first();

        if($tenant) {
            $cidade = Cidade::where('nome', 'Lorena')->first();

            $endereco = $tenant->enderecos()->create([
                'cep' => '12610185',
                'rua' => 'Rua Dr Laércio Lincoln Figueira',
                'numero' => 'D19',
                'bairro' => 'Portal das Palmeiras',
                'complemento' => '',
                'cidade_id' => $cidade->id,
                'estado_id' => $cidade->estado_id
            ]);

            $tenant->prestadoresservicos()->create([
                'tipo' => 'pessoa_fisica',
                'categoria' => 'TI',
                'nome' => 'William',
                'sobrenome' => 'Almeida',
                'cpf' => '41754494854',
                'rg' => null,
                'nascimento' => '1994-05-05',
                'telefone' => '12982184879',
                'whatsapp' => '12982184879',
                'email' => null,
                'endereco_id' => $endereco->id,
                'descricao' => 'Suporte de TI para o condomínio',
            ]);
        }
    }
}
