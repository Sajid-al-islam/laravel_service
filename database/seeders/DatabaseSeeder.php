<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::where('email', 'admin@gmail.com')->first();

        if(!$user) {
            User::factory()->create([
                'name' => 'admin user',
                'email' => 'admin@gmail.com',
                'phone_number' => '01234567891',
                'password' => Hash::make('@12345678')
            ]);
        }

        User::factory(5)->create();
    }
}
