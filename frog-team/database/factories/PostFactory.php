<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Get existing user and category records
        $user = User::inRandomOrder()->first();
        $category = Category::inRandomOrder()->first();

        return [
            'user_id' => $user->id,
            'category_id' => $category->id,
            'title' => $this->faker->sentence,
            'slug' => $this->faker->slug,
            'excerpt' => '<p>' . implode('</p><p>', $this->faker->paragraphs(2)) . '<p>',
            'body' => '<p>' . implode('</p><p>', $this->faker->paragraphs(6)) . '<p>',
            'created_at' => now(),
            'updated_at' => now(),
            'published_at' => now(),
        ];
    }
}

