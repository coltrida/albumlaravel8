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
    public function run()
    {
        $cats = [
            'abstract', 'animals', 'business', 'cats', 'city', 'food', 'fashion', 'people', 'nature', 'sports', 'trips', 'zoo'
        ];

        foreach ($cats as $cat){
            Category::create([
                'category_name' => $cat
            ]);
        }
    }
}
