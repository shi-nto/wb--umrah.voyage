<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AgentUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'agent@gmail.com'],
            [
                'name' => 'Agent',
                'password' => Hash::make('agent123'),
                'role' => 'agent',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        \App\Models\User::factory(39)->create(['role' => 'agent']);
    }
}