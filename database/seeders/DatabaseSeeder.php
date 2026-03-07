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

        User::factory()->create([
            'name' => 'Yad Hoshyar',
            'email' => 'user@example.com',
        ]);

        $this->call([
//            AlertSeeder::class,
            TeknykarSensorSeeder::class,
            AlertRuleSeeder::class,
//            MapPinSeeder::class,
            IncidentTypeSeeder::class,
//            IncidentSeeder::class,
        ]);
    }
}
