<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
*/

class ProjectFactory extends Factory {
    /**
    * Define the model's default state.
    *
    * @return array<string, mixed>
    */

    // Por si acaso las fotos no van:
    // 'https://placehold.co/600x400/7eb0ba/FFF',

    public function definition(): array {
        return [
            'title' => fake()->name(),
            'user_id' => User::factory()->entrepreneur(), 
            'url_Img' => 'https://placehold.co/600x400/' . dechex(random_int(0, 0xFFFFFF)) . '/fff/png',
            'url_Video' => 'http://commondatastorage.googleapis.com/gtv-videos-bucket/sample/ElephantsDream.mp4',
            'current_investment' => 0,
            'max_investment' => fake()->randomFloat(2, 1000, 10000),
            'min_investment' => fake()->randomFloat(2, 1, 100),
            'state' => fake()->randomElement(['active', 'inactive', 'pending']),
            'description' => fake()->text(),
            'limit_date' => fake()->dateTimeBetween('now', '+1 year'),
        ];
    }
}