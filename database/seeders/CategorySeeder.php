<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->count(2)->create(['parent_id' => null]);
        Category::factory()->count(2)->create(['parent_id' => 1]);
        Category::factory()->count(2)->create(['parent_id' => 2]);
    }
}
