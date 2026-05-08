<?php

namespace Database\Factories;

use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Pet>
 */
class PetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => 'pets/default.jpg',
            'name' => fake()->firstName(),
            'species' => fake()->randomElement(['Cat', 'Dog']),
            'breed' => fake()->word(),
            'color' => fake()->safeColorName(),
            'gender' => fake()->randomElement(['male', 'female']),
            'dob' => fake()->date(),
            'weight' => fake()->randomFloat(2, 1, 50),
            'description' => fake()->sentence(),
        ];
    }
}
