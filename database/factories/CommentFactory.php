<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // public function definition(): array
    // {
    //     $createdAt = fake()->dateTimeBetween('-2 years', '-1 year'); // تاريخ إنشاء بين سنتين وسنة من الآن
    //     $updatedAt = fake()->dateTimeBetween($createdAt, 'now'); // تحديث بعد الإنشاء وقبل الآن

    //     $parentComment = Comment::inRandomOrder()->first();
    //     $parent_id = $parentComment ? $parentComment->id : null;
    //     return [
    //         'comment' => fake()->paragraph(3),
    //         'ip_address' => fake()->ipv4(),
    //         'status' => rand(0,1),
    //         'post_id'=> Post::inRandomOrder()->first()->id ?? null,
    //         'user_id'=> User::inRandomOrder()->first()->id,
    //         // 'parent_id'=> Comment::inRandomOrder()->first()->id,
    //         'parent_id' => fake()->boolean(50) ? $parent_id : null, // 50% يكون لديه parent_id
    //         'created_at' => $createdAt,
    //         'updated_at' => $updatedAt,
    //     ];
    // }

    //     public function definition(): array
    // {
    //     $createdAt = fake()->dateTimeBetween('-2 years', '-1 year'); // تاريخ إنشاء بين سنتين وسنة من الآن
    //     $updatedAt = fake()->dateTimeBetween($createdAt, 'now'); // تحديث بعد الإنشاء وقبل الآن

    //     // الحصول على تعليق رئيسي (parent comment) بشكل عشوائي
    //     $parentComment = Comment::whereNull('parent_id')->inRandomOrder()->first();
    //     $parent_id = $parentComment ? $parentComment->id : null;

    //     return [
    //         'comment' => fake()->paragraph(3),
    //         'ip_address' => fake()->ipv4(),
    //         'status' => rand(0,1),
    //         'post_id'=> Post::inRandomOrder()->first()->id ?? null,
    //         'user_id'=> User::inRandomOrder()->first()->id ?? null,
    //         'parent_id' => fake()->boolean(50) ? $parent_id : null, // 50% احتمال أن يكون لديه parent_id
    //         'created_at' => $createdAt,
    //         'updated_at' => $updatedAt,
    //     ];
    // }

    public function definition(): array
    {
        $createdAt = fake()->dateTimeBetween('-2 years', '-1 year');
        $updatedAt = fake()->dateTimeBetween($createdAt, 'now');

        // الحصول على تعليق رئيسي (parent comment) بشكل عشوائي
        $parentComment = Comment::whereNull('parent_id')->inRandomOrder()->first();

        // إذا وُجد تعليق رئيسي، استخدم post_id الخاص به، وإلا اختر post_id عشوائي جديد
        $post_id = $parentComment ? $parentComment->post_id : (Post::inRandomOrder()->first()->id ?? null);

        return [
            'comment' => fake()->paragraph(3),
            'ip_address' => fake()->ipv4(),
            'status' => rand(0, 1),
            'post_id' => $post_id, // تأكد أن post_id واحد للتعليق الأب أو الابن
            'user_id' => User::inRandomOrder()->first()->id ?? null,
            // 'parent_id' => fake()->boolean(50) ? $parentComment->id : null, // 50% احتمال أن يكون لديه parent_id
            'parent_id' => ($parentComment && fake()->boolean(50)) ? $parentComment->id : null,

            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
