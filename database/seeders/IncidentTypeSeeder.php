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
        $types = ['Car Crash', 'Fire', 'Flood', 'Gas Leak', 'Power Outage', 'Road Block', 'Other'];

        foreach ($types as $type) {
            IncidentType::query()->firstOrCreate(['name' => $type]);
        }
    }
}
