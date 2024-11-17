<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = ['tecnology !Category','spoort Category','AI Category','Java Language'];
        $createdAt = fake()->dateTimeBetween('-2 years', '-1 year'); // تاريخ إنشاء بين سنتين وسنة من الآن
        $updatedAt = fake()->dateTimeBetween($createdAt, 'now'); // تحديث بعد الإنشاء وقبل الآن
        foreach ($data as $item) {
            Category::create([
                'name' => $item,
                'slug' => Str::slug($item),
                'status' => rand(0,1),
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
           ]);
        }

    }
}
