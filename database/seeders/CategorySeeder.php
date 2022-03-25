<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
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
            $user_id = User::inRandomOrder()->pluck('id')->first();
            Category::create([
                'category_name' => $cat,
                'user_id' => $user_id
            ]);
        }
    }
}
