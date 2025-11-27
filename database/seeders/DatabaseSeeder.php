<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            AdminUserSeeder::class,
            AgentSeeder::class,
            EventSeeder::class,
            HotelSeeder::class,
            RoomSeeder::class,
            PilgrimSeeder::class,
            PassportInfoSeeder::class,
            RelationshipSeeder::class,
            AlertSeeder::class,
            PackageSeeder::class,
            TransportSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
