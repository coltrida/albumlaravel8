<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\AlbumCategory;
use App\Models\Category;
use App\Models\Photo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*$this->call(UserSeeder::class);
        $this->call(AlbumSeeder::class);
        $this->call(PhotoSeeder::class);*/

        \DB::statement('SET FOREIGN_KEY_CHECKS=0');

        User::truncate();
        Album::truncate();
        Photo::truncate();
        Category::truncate();
        AlbumCategory::truncate();



        User::factory(20)->has(
            Album::factory(10)->has(
                Photo::factory(20)
            )
        )->create();

        $user = User::find(1);
        $user->update([
            'name' => 'cacao',
            'email' => 'cacao@cacao.it',
            'user_role' => 'admin',
            'email_verified_at' => now(),
            'password' => \Hash::make('123456'),
            'remember_token' => 'sdafIOKKHy',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $user = User::find(2);
        $user->update([
            'name' => 'cacao2',
            'email' => 'cacao2@cacao.it',
            'user_role' => 'user',
            'email_verified_at' => now(),
            'password' => \Hash::make('123456'),
            'remember_token' => 'sdafIOKKHy',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $this->call(CategorySeeder::class);
        $this->call(AlbumCategorySeeder::class);
    }
}
