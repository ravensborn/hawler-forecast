<?php

namespace Database\Seeders;

use App\Models\Incident;
use App\Models\IncidentType;
use Illuminate\Database\Seeder;

class IncidentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeIds = IncidentType::query()->pluck('id');

        Incident::factory(5)->create([
            'incident_type_id' => fn () => $typeIds->random(),
        ]);
    }
}
