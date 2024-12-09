<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 5; $i++) {
            DB::table('rooms')->insert([
                'name' => $faker->word(),
                'image'=> $faker->imageUrl(),
                'min_capacity' => rand(1, 3),
                'max_capacity' => rand(3,6),
                'type_id' => rand(1,3)
            ]);
        }
    }
}
