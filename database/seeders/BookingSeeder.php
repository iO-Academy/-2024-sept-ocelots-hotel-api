<?php

namespace Database\Seeders;

use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i=0; $i<3; $i++){
            DB::table('bookings')->insert([
                'room_id'=>rand(1,5),
                'customer'=>$faker->name(),
                'guests'=>3,
                'start'=>$faker->date(),
                'end'=>$faker->date(),
            ]);
        }
    }
}
