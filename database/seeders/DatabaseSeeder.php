<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Menjalankan Seeder User (Admin & Customer)
        $this->call([
            UserSeeder::class,
            MenuSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
