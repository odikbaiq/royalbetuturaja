<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::updateOrCreate(
            ['name' => 'Tour Sejarah'],
            [
                'description' => 'Menghadirkan pengalaman menarik tentang sejarah kerajaan Puri Ageng Sukawati.',
                'price' => 100000,
                'image' => 'img/feature/tur-sejarah.png',
            ]
        );

        Service::updateOrCreate(
            ['name' => 'Gala Dinner'],
            [
                'description' => 'Gala dinner yang diselenggarakan di dalam istana kerajaan Puri Ageng Sukawati.',
                'price' => 500000,
                'image' => 'img/feature/galladinner.png',
            ]
        );

        Service::updateOrCreate(
            ['name' => 'Cooking Class'],
            [
                'description' => 'Kelas memasak yang mengajarkan cara membuat masakan tradisional khas Puri Ageng Sukawati.',
                'price' => 350000,
                'image' => 'img/feature/cooking-class.png',
            ]
        );
    }
}
