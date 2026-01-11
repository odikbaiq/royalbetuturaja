<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate([
            'email' => 'odikpramana08@gmail.com',
        ], [
            'name' => 'Adminroyalbetuturaja',
            'password' => Hash::make('RBTRaja@2026'),
            'role' => 'admin',
        ]);

        \App\Models\User::updateOrCreate([
            'email' => 'odikpramana8@gmail.com',
        ], [
            'name' => 'PTUNHITravel',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);
    }
}
