<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('type', User::ADMIN)->first();

        $tenants = Tenant::factory(1)->create([
            'nome_fantasia' => 'Condominio '.$user->name,
        ]);

        if($user) {
            foreach($tenants as $tenant) {
                $tenant->users()->attach($user);
            }
        }

        $user = User::where('type', User::CONDOMINIO)->first();

        $tenants = Tenant::factory(1)->create([
            'nome_fantasia' => 'Condominio '.$user->name,
        ]);

        if($user) {
            foreach($tenants as $tenant) {
                $tenant->users()->attach($user);
            }
        }
    }
}
