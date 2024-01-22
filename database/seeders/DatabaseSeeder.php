<?php

namespace Database\Seeders;

use App\Models\Toko;
use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        Role::create([
            'name' => 'admin',
            'guard_name' => 'web'
        ]);

        Role::create([
            'name' => 'customer',
            'guard_name' => 'web'
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@aneka.id',
            'password' => bcrypt('12345678'),
        ]);

        $admin->assignRole('admin');

        $admin = User::create([
            'name' => 'Customer',
            'email' => 'customer@aneka.id',
            'password' => bcrypt('12345678'),
        ]);

        $admin->assignRole('customer');

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

        Product::create([
            'categori_id' => 4,
            'name' => 'Beng Beng',
            'photo' => 'BengBeng.png',
            'price' => 55200,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Satu Box Berisikan 17 Pcs'
        ]);

        Product::create([
            'categori_id' => 3,
            'name' => 'Beras Maknyuss',
            'photo' => 'BerasMaknyuss.png',
            'price' => 75000,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Beras Pulen Berkualitas'
        ]);

        Product::create([
            'categori_id' => 3,
            'name' => 'Blue Band',
            'photo' => 'BlueBand.png',
            'price' => 650000,
            'weight' => 100,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 48 Pcs'
        ]);
        //2
        Product::create([
            'categori_id' => 5,
            'name' => 'Dove Deep Moisture',
            'photo' => 'DoveDeepMoisture.png',
            'price' => 440000,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 10 Pcs'
        ]);

        Product::create([
            'categori_id' => 2,
            'name' => 'Good Day Cappucino',
            'photo' => 'GoodDayCappucino.png',
            'price' => 125000,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 24 Pcs'
        ]);

        Product::create([
            'categori_id' => 3,
            'name' => 'Indomie Goreng',
            'photo' => 'IndomieGoreng.png',
            'price' => 111000,
            'weight' => 100,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 40 Pcs'
        ]);
        //3
        Product::create([
            'categori_id' => 3,
            'name' => 'Masako Kaldu Sapi',
            'photo' => 'Masako.png',
            'price' => 275000,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 120 Pcs'
        ]);

        Product::create([
            'categori_id' => 3,
            'name' => 'Bimoli Botol 2L',
            'photo' => 'MinyakBimoli.png',
            'price' => 220000,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 6 Pcs'
        ]);

        Product::create([
            'categori_id' => 1,
            'name' => 'Molto Pewangi 1800 Ml',
            'photo' => 'MoltoPewangi.png',
            'price' => 800000,
            'weight' => 100,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 10 Pcs'
        ]);
        //4
        Product::create([
            'categori_id' => 5,
            'name' => 'Nivea Aclarado',
            'photo' => 'NiveaAclarado.png',
            'price' => 750000,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 10 Pcs'
        ]);

        Product::create([
            'categori_id' => 5,
            'name' => 'Pepsodent 120 Gram',
            'photo' => 'Pepsodent.png',
            'price' => 95000,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 12 Pcs'
        ]);

        Product::create([
            'categori_id' => 1,
            'name' => 'Rinso Molto 1 Kg',
            'photo' => 'Rinso.png',
            'price' => 300000,
            'weight' => 100,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 12 Pcs'
        ]);
        //5
        Product::create([
            'categori_id' => 3,
            'name' => 'Sedaap Goreng',
            'photo' => 'SedaapGoreng.png',
            'price' => 130000,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 40 Pcs'
        ]);

        Product::create([
            'categori_id' => 3,
            'name' => 'SKM Indomilk 560 Ml',
            'photo' => 'SKMIndomilk.png',
            'price' => 450000,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 24 Pcs'
        ]);

        Product::create([
            'categori_id' => 3,
            'name' => 'SKM Frisian Flag Kaleng',
            'photo' => 'SKMFF.png',
            'price' => 575000,
            'weight' => 100,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 40 Pcs'
        ]);
        //6
        Product::create([
            'categori_id' => 1,
            'name' => 'Soklin Lantai 770 Ml',
            'photo' => 'SoKlinLantai.png',
            'price' => 155000,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 12 Pcs'
        ]);

        Product::create([
            'categori_id' => 5,
            'name' => 'Vaseline Aloe Fresh 100 Ml',
            'photo' => 'VaselineAloeFresh.png',
            'price' => 580000,
            'weight' => 1000,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 10 Pcs'
        ]);

        Product::create([
            'categori_id' => 3,
            'name' => 'Vaselien Petroleum Jelly',
            'photo' => 'VaselineJelly.png',
            'price' => 490000,
            'weight' => 100,
            'stock' => 200,
            'description' => 'Satu Dus Berisikan 10 Pcs'
        ]);

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
