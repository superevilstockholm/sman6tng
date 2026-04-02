<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

// Models
use App\Models\Account\User;

// Enums
use App\Enums\RoleEnum;

/**
 * @extends Factory<User>
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
        return [
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => null,
            'password' => static::$password ??= Hash::make('Password#123'),
            'remember_token' => Str::random(10),
            'role' => fake()->randomElement([
                RoleEnum::TEACHER,
                RoleEnum::STUDENT,
                RoleEnum::STUDENT,
            ]),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function verified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => now(),
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => RoleEnum::ADMIN,
        ]);
    }

    public function teacher(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => RoleEnum::TEACHER,
        ]);
    }

    public function student(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => RoleEnum::STUDENT,
        ]);
    }
}
