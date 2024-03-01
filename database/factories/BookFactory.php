<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::inRandomOrder()->first(),
            'title' => $this->faker->name(),
            'author' => $this->faker->name(),
            'price' => $this->faker->numberBetween(2000, 10000),
            'publication_date' => now()->subDays(rand(1, 10)),
            'description' => $this->faker->paragraph(5),
        ];
    }
}
