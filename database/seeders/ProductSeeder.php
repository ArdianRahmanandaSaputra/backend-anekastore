<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        //1
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
    }
}
