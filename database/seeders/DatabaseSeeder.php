<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Book;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\WishList;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => 'password'
        ]);

        User::factory(10)->create();
        Book::factory(10)->create();
        Cart::factory(10)->create();
        Order::factory(10)->create();
        WishList::factory(10)->create();
    }
}
