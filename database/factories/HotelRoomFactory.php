<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HotelRoom>
 */
class HotelRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => rand(1, 20),
            'name' => $this->faker->word(),
            'image' => $this->faker->imageUrl(),
            'min_capacity' => rand(1, 3),
            'max_capacity' => rand(3, 6),
            'type_id' => rand(1, 3),
        ];
    }
}
