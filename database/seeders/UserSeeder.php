<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
