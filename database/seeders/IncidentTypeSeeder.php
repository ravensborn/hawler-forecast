<?php

namespace Database\Seeders;

use App\Models\IncidentType;
use Illuminate\Database\Seeder;

class IncidentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = ['car-crash', 'fire', 'flood', 'gas-leak', 'power-outage', 'road-block', 'other'];

        foreach ($types as $type) {
            IncidentType::query()->firstOrCreate(['name' => $type]);
        }
    }
}
