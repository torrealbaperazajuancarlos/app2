<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
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
            'title' => fake()->sentence(3),
            'category_id' => Category::factory(),
            'author_id' => Author::factory(),
            'summary' => fake()->sentence(),
            'pdf' => 'books/'.fake()->uuid().'.pdf',
            'image' => 'books/'.fake()->uuid().'.jpg',
        ];
    }
}
