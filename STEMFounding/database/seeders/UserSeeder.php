<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
    * Run the database seeds.
    */

    public function run(): void {
        
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 'admin'

        ]);

        User::factory()->create([
            'name' => 'Felipe',
            'email' => 'felitol2008@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 'entrepreneur'
        ]);

        User::factory()->create([
            'name' => 'investor',
            'email' => 'fjrnte@gmail.com',
            'password' => Hash::make('1234'),
            'role' => 'investor'
        ]);

        User::factory(100)->create();
    }
}
