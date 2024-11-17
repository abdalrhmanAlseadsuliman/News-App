<?php

namespace Database\Seeders;

use App\Models\Interact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InteractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Interact::factory()->count(100)->create();
    }
}
