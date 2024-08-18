<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(PaisesSeeder::class);
        $this->call(EstadosSeeder::class);
        $this->call(CidadesSeeder::class);
        
        $this->call(UsersSeeder::class);

        $this->call(TenantSeeder::class);

        $this->call(RolesAndPermissionsSeeder::class);

        $this->call(BlocosSeeder::class);
        $this->call(MoradoresSeeder::class);
        $this->call(ImoveisSeeder::class);
        $this->call(PetsSeeder::class);
        $this->call(VeiculosSeeder::class);
        $this->call(PrestadoresServicosSeeder::class);
        $this->call(EmpresasServicosSeeder::class);
    }
}
