<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('SEED_ADMIN_EMAIL', 'admin@umrah.com');
        $name = env('SEED_ADMIN_NAME', 'Administrator');
        $rawPassword = env('SEED_ADMIN_PASSWORD', 'password');

        // If the default password is still used, add a random suffix to discourage production usage
        if ($rawPassword === 'password' && app()->environment('production')) {
            $rawPassword = 'password' . Str::random(8);
        }

        DB::table('users')->updateOrInsert(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($rawPassword),
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
