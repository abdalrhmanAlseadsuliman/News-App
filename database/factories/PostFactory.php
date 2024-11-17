<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $createdAt = fake()->dateTimeBetween('-2 years', '-1 year'); // تاريخ إنشاء بين سنتين وسنة من الآن
        $updatedAt = fake()->dateTimeBetween($createdAt, 'now'); // تحديث بعد الإنشاء وقبل الآن
        $publishAt = fake()->dateTimeBetween($updatedAt, '+1 year'); // النشر بعد التحديث
        return [
            "title"=> fake()->sentence(3),
            'description' => fake()->paragraph(60),
            'status' => fake()->randomElement(['active','archived']),
            'comment_able' => rand(0,1),
            'num_of_views' => rand(0,100),
            'user_id' => User::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
            'published_at' => $publishAt,
        ];
    }
}
