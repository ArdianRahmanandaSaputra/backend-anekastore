<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Toko;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Toko::create([
            'id' => 1,
            'name' => 'Aneka Store',
            'email' => 'aneka@mail.id',
            'province' => 'Jawa Timur',
            'province_code' => 11,
            'city' => 'Mojokerto',
            'city_code' => 256,
            'postal_code' => 61351,
            'phone' => '0812345678',
        ]);
    }
}
