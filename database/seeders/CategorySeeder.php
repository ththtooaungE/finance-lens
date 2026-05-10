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
            ['user_id' => 1, 'name' => 'Food', 'color' => '#FCCD86', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Snack & Dessert', 'color' => '#FCCD86', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Meet up with Friends', 'color' => '#FCCD86', 'is_active' => true],

            ['user_id' => 1, 'name' => 'Transport', 'color' => '#33C1FF', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Education & University Fees', 'color' => '#FFEB7A', 'is_active' => true],

            ['user_id' => 1, 'name' => 'Cosmetics & Skincare', 'color' => '#F49AA2', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Clothing and Fashion', 'color' => '#F5A0C4', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Health & Medicines', 'color' => '#A8BF8A', 'is_active' => true],

            ['user_id' => 1, 'name' => 'Entertainment', 'color' => '#D3BCF0', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Utilities', 'color' => '#A4D1F2', 'is_active' => true],
            ['user_id' => 1, 'name' => 'Unnecessary', 'color' => '#FEF8FA   ', 'is_active' => true],
        ];

        foreach ($categories as $category) {
            \App\Models\Category::create($category);
        }
    }
}
