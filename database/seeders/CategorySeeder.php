<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Technology'],
            ['name' => 'Science'],
            ['name' => 'Business'],
            ['name' => 'Art'],
            ['name' => 'Health'],
            ['name' => 'Sports'],
            ['name' => 'Music'],
            ['name' => 'Fashion'],
            ['name' => 'Food'],
            ['name' => 'Travel'],
            ['name' => 'Education'],
            ['name' => 'Books'],
            ['name' => 'Movies'],
            ['name' => 'Gaming'],
            ['name' => 'Environment'],
            ['name' => 'Politics'],
            // Add more categories as needed
        ];

        Category::insert($categories);
    }
}
