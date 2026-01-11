<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $menus = [
            [
                'name' => 'Ayam Betutu Klasik Puri Ageng',
                'description' => 'Ayam betutu khas Sukawati yang dimasak selama 12 jam dengan bumbu genep warisan leluhur.',
                'price' => 125000,
                'image' => 'menus/ayam-betutu.jpg',
            ],
        ];

        foreach ($menus as $menu) {
            Menu::create($menu);
        }
    }
}
