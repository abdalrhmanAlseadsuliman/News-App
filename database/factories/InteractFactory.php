<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Interact>
 */
class InteractFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $typeName = fake()->randomElement(['LIKE', 'HAHA', 'SAD', 'DISLIKE', 'GOOD']);

        // تعيين type_code بناءً على type_name
        $typeCode = match ($typeName) {
            'LIKE'     => 1,
            'HAHA'     => 2,
            'SAD'      => 3,
            'DISLIKE'  => 4,
            'GOOD'     => 5,
            default    => null,
        };
        $isPostInteraction = fake()->boolean(50); // 50% احتمال أن يكون التفاعل مع المنشور

        return [
            'type_name' => $typeName,
            'type_code' => $typeCode,
            'user_id' => User::inRandomOrder()->first()->id,
            'post_id' => $isPostInteraction ? Post::inRandomOrder()->first()->id : null,
            'comment_id' => !$isPostInteraction ? Comment::inRandomOrder()->first()->id : null,
        ];
    }
}
