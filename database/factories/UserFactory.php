<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $images = ['team-1.jpg', 'team-2.jpg','team-3.jpg','team-4.jpg','team-5.jpg'];
        $temp_imgs = $images;
        array_push($temp_imgs, 'avatar.png');
        foreach ($temp_imgs as $image) {
            $sourcePath = public_path('assets/img/' . $image);
            $destinationPath = 'public/images/' . $image;
            Storage::put($destinationPath, file_get_contents($sourcePath));
        }

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->phoneNumber(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'photo' => 'images/' . $images[array_rand($images)],
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
