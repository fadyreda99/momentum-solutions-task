<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {
            DB::table('products')->insert([
                'name' => $faker->word(),
                'price' => $faker->randomFloat(2, 10, 100), // Random float with 2 decimal places, between 10 and 100
                'inventory' => $faker->numberBetween(1, 100), // Random integer between 1 and 100
            ]);
        }
    }
}
