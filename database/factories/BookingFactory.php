<?php

namespace Database\Factories;

use App\Models\HotelRoom;
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
            'customer' => $this->faker->name(),
            'room_id' => HotelRoom::factory(),
            'guests' => 3,
            'start' => $this->faker->date(),
            'end' => $this->faker->date(),
        ];
    }
}
