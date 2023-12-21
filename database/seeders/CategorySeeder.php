<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        Category::create([
            'id' => 1,
            'name' => 'Perawatan Rumah',
            'photo' => 'Rumah.png',
            'description' => ''
        ]);

        Category::create([
            'id' => 2,
            'name' => 'Minuman',
            'photo' => 'Minuman.png',
            'description' => ''
        ]);

        Category::create([
            'id' => 3,
            'name' => 'Bahan Pokok',
            'photo' => 'Pokok.png',
            'description' => ''
        ]);

        Category::create([
            'id' => 4,
            'name' => 'Makanan',
            'photo' => 'Makanan.png',
            'description' => ''
        ]);

        Category::create([
            'id' => 5,
            'name' => 'Perawatan Tubuh',
            'photo' => 'PerawatanTubuh.png',
            'description' => ''
        ]);
    }
}
