<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['user_id' => 1, 'name' => 'Food & Meals', 'color' => '#29be23', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Snack & Dessert', 'color' => '#FCCD86', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Meet up, Party & Celebration', 'color' => '#dc5353', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Health & Medicines', 'color' => '#caee9a', 'is_active' => true],

            ['user_id' => 1, 'name' => 'Transport', 'color' => '#33C1FF', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Education & University Fees', 'color' => '#FFEB7A', 'is_active' => true],

            ['user_id' => 1, 'name' => 'Cosmetics & Skincare', 'color' => '#F5A0C4', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Personal Hygiene & Haircut', 'color' => '#c6447a', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Clothing and Fashion', 'color' => '#d50059', 'is_active' => true],

            ['user_id' => 1, 'name' => 'Utilities for necessity', 'color' => '#93c6eb', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Utilities for lust', 'color' => '#c2a4e5', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Uncategorized', 'color' => '#FEF8FA   ', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
