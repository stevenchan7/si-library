<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category::class>
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
        $stock = fake()->randomNumber(1) + 1;
        return [
            'title' => fake()->sentence(mt_rand(1, 6)),
            'isbn' => fake()->isbn10(),
            'author' => fake()->name(),
            'publisher' => fake()->sentence(mt_rand(2, 3)),
            'release_date' => fake()->date(),
            'stock' => $stock,
            'available_stock' => $stock - 1,
            'category_id' => mt_rand(1, 3)
        ];
    }
}
