<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\RoomType>
 */
class RoomTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Standard Room',
            'Deluxe Room',
            'Executive Suite',
            'Family Room',
            'Ocean View Suite',
            'Presidential Suite',
            'Twin Room',
            'Garden View Room',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'base_price' => fake()->randomFloat(2, 50, 500),
            'capacity' => fake()->numberBetween(1, 6),
        ];
    }
}