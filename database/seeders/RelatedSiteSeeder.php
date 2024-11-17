<?php

namespace Database\Seeders;

use App\Models\RelatedSite;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RelatedSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Factory::create();
        for ($i = 0; $i < 5; $i++) {
            RelatedSite::create([
                'name'=> $faker->sentence(1),
                'url'=> $faker->url(),
            ]);
        }
    }
}
