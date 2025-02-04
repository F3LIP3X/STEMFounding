<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
* @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
*/

class UserFactory extends Factory {
    /**
    * The current password being used by the factory.
    */
    protected static ?string $password;

    /**
    * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    //  Por si falla la imagen 
    // 'https://placehold.co/100x100@2x.png',

    public function definition(): array
    {   

        return[
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['entrepreneur', 'investor']),
            'banned' => fake()->boolean(),
            'balance' => fake()->randomFloat(2, 0, 1000),
            'urlImg' => 'https://placehold.co/600x400/' . dechex(random_int(0, 0xFFFFFF)) . '/fff/png',
            'IBAN' => fake()->iban('ES'),

        ];

        
    }

    /**º
     * Indicate that the model's email address should be unverified.
    */

    public function entrepreneur(){
        return $this->state(function (array $attributes) {
            return [
            'role' => 'entrepreneur',
            ];
        });
    }

    public function unverified(): static {
        return $this->state( fn ( array $attributes ) => [
            'email_verified_at' => null,
        ] );
    }
}