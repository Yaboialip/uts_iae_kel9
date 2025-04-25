<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('menus')->insert([
            [
                'name' => 'Espresso',
                'description' => 'Kopi hitam pekat khas Italia',
                'price' => 15000,
            ],
            [
                'name' => 'Cappuccino',
                'description' => 'Kopi susu dengan foam lembut',
                'price' => 18000,
            ],
            [
                'name' => 'Latte',
                'description' => 'Perpaduan espresso dengan susu yang creamy',
                'price' => 19000,
            ],
            [
                'name' => 'Americano',
                'description' => 'Espresso dicampur dengan air panas',
                'price' => 16000,
            ],
            [
                'name' => 'Mocha',
                'description' => 'Kopi susu dengan coklat hangat',
                'price' => 20000,
            ],
            [
                'name' => 'Caramel Macchiato',
                'description' => 'Latte dengan sirup karamel manis di atasnya',
                'price' => 22000,
            ],
            [
                'name' => 'Matcha Latte',
                'description' => 'Perpaduan teh hijau Jepang dan susu',
                'price' => 23000,
            ],
            [
                'name' => 'Kopi Susu Gula Aren',
                'description' => 'Espresso dengan susu dan gula aren khas Nusantara',
                'price' => 18000,
            ],
            
        ]);
    }
}