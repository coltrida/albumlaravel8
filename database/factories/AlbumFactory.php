<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'album_name' => $this->faker->text(60),
            'album_thumb' => $this->faker->imageUrl(640, 480, 'cats'),
            'description' => $this->faker->text(120),
            'created_at' => $this->faker->dateTime(),
         //   'user_id' => User::inRandomOrder()->first()->id
            'user_id' => User::factory()
        ];
    }
}
