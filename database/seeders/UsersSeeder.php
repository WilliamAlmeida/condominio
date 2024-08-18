<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'William',
            'email' => 'williamkillerca@hotmail.com',
            'password' => '123456',
            'type' => User::ADMIN,
        ]);

        User::factory()->create([
            'name' => 'Condomínio',
            'email' => 'condominio@hotmail.com',
            'password' => '123456',
            'type' => User::CONDOMINIO,
        ]);

        User::factory()->create([
            'name' => 'Usuário Comum',
            'email' => 'user@hotmail.com',
            'password' => '123456',
            'type' => User::USER,
        ]);
    }
}
