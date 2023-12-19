<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use factory to create categories
        Category::factory()->count(10)->create();

        // Additional logic to prevent duplicates
        $this->preventDuplicates();
    }

    /**
     * Additional logic to prevent duplicate categories.
     */
    private function preventDuplicates(): void
    {
        $categories = Category::all();

        foreach ($categories as $category) {
            // Use firstOrCreate to ensure uniqueness based on the 'name' column
            Category::firstOrCreate(['name' => $category->name], ['slug' => $category->slug]);
        }
    }
}
