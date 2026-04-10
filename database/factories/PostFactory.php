<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'user_id'          => User::factory(),
            'category_id'      => Category::factory(),
            'title'            => $title,
            'slug'             => Str::slug($title),
            'excerpt'          => $this->faker->paragraph(2),
            'body'             => collect(range(1, 4))
                ->map(fn () => '<p>' . $this->faker->paragraph(5) . '</p>')
                ->join("\n"),
            'published_at'     => $this->faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
            'meta_title'       => null,
            'meta_description' => null,
        ];
    }

    public function published(): static
    {
        return $this->state(fn () => ['published_at' => now()->subDays(rand(1, 60))]);
    }

    public function draft(): static
    {
        return $this->state(fn () => ['published_at' => null]);
    }
}
