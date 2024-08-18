<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Files;
use App\Models\Tenant;
use App\Models\Horarios;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResetCondominios extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Horarios::truncate();
        Files::truncate();

        foreach (Tenant::get() as $tenant) {
            $tenant->users()->sync([]);
        }

        Tenant::query()->delete();

        User::query()->update(['condominios_id' => null]);
    }
}
