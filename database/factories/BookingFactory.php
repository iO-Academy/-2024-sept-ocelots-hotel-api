<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'room_id' => rand(1, 5),
            'customer'=> $this->faker->name(),
            'guests'=> rand(1, 5),
            'start'=>$this->faker->date(),
            'end'=>$this->faker->date(),
        ];
    }
}
