<?php

namespace Database\Factories;

use App\Models\Cidade;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tenant>
 */
class TenantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cidade = Cidade::with('estado.pais')->inRandomOrder()->first();

        $company = fake()->company;
        
        return [
            'id_tipo_condominio' => fake()->randomElement(array_column(Tenant::$tipos_condominios, 'id')),
            'nome_fantasia' => $company,
            'slug' => Str::slug($company),
            'razao_social' => Str::of($company)->upper(),
            'idpais' => $cidade->estado->pais->id ?: 0,
            'estado_id' => $cidade->estado->id ?: 0,
            'cidade_id' => $cidade->id ?: 0,
            'cnpj' => fake()->numerify('##############'),
            'inscricao_estadual' => fake()->numerify('##############'),
            'cpf' => fake()->numerify('###########'),
            'end_logradouro' => fake()->streetName,
            'end_numero' => fake()->buildingNumber,
            'end_complemento' => fake()->secondaryAddress,
            'end_bairro' => fake()->streetSuffix,
            'end_cidade' => fake()->city,
            'end_cep' => fake()->postcode,
            'keywords' => fake()->words(3, true),
            'description' => fake()->sentence,
        ];
    }
}
