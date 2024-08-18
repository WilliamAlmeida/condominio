<?php

namespace Database\Seeders;

use App\Models\Cidade;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmpresasServicosSeeder extends Seeder
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

            $tenant->empresasservicos()->create([
                'categoria' => 'TI',
                'cnpj' => '12345678901234',
                'razao_social' => 'W. M. Solucções Tecnologicas',
                'nome_fantasia' => 'W. M. Soluções Tecnologicas',
                'inscricao_estadual' => null,
                'inscricao_municipal' => null,
                'telefone_1' => '12982184879',
                'telefone_2' => '12982184879',
                'whatsapp' => '12982184879',
                'email' => null,
                'site' => null,
                'endereco_id' => $endereco->id,
                'foto_id' => null,
                'descricao' => 'Empresa de soluções tecnologicas',
            ]);
        }
    }
}
