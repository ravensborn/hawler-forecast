<?php

use App\Models\IncidentType;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns all incident types', function () {
    $types = IncidentType::factory()->count(3)->create();

    $this->getJson(route('incident-types.index'))
        ->assertSuccessful()
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name'],
            ],
        ]);
});

it('does not require authentication', function () {
    $this->getJson(route('incident-types.index'))
        ->assertSuccessful();
});
