<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

// Models
use App\Models\Account\User;

// Enums
use App\Enums\RoleEnum;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // First admin user seeder
        DB::transaction(function () {
            $admin_user = User::updateOrCreate([
                'email' => config('admin.email'),
            ], [
                'email' => config('admin.email'),
                'password' => config('admin.password'),
                'role' => RoleEnum::ADMIN,
                'email_verified_at' => now(),
            ]);

            $admin_user->profile()->updateOrCreate([], [
                'name' => config('admin.name'),
            ]);
        });
    }
}
