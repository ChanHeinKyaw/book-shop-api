<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = ["pending","complete"];
        return [
            'user_id' => User::inRandomOrder()->first(),
            'book_id' => Book::inRandomOrder()->first(),
            'quantity' => rand(1,10),
            'status' => $status[rand(0,1)],
        ];
    }
}
