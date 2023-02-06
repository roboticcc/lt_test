<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $categories = [
            'Fundamentals',
            'String',
            'Algorithms',
            'Mathematic',
            'Performance',
            'Booleans',
            'Functions'
        ];

        foreach ($categories as $categoryTitle){
            Category::create([
                'title' => $categoryTitle
            ]);
        }
    }
}
