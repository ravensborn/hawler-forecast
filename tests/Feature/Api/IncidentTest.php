<?php

use App\Models\IncidentType;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('creates an incident successfully', function () {
    $incidentType = IncidentType::factory()->create();

    $payload = [
        'description' => 'A car crash on the highway',
        'phoneNumber' => '+1234567890',
        'identifier' => 'INC-001',
        'incidentTypeId' => $incidentType->id,
        'latitude' => 36.1901230,
        'longitude' => 44.0091150,
    ];

    $this->postJson(route('incidents.store'), $payload)
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                'id',
                'description',
                'phoneNumber',
                'identifier',
                'incidentTypeId',
                'latitude',
                'longitude',
                'createdAt',
            ],
        ])
        ->assertJsonPath('data.description', $payload['description'])
        ->assertJsonPath('data.phoneNumber', $payload['phoneNumber'])
        ->assertJsonPath('data.identifier', $payload['identifier'])
        ->assertJsonPath('data.incidentTypeId', $incidentType->id);

    $this->assertDatabaseHas('incidents', [
        'description' => $payload['description'],
        'phone_number' => $payload['phoneNumber'],
        'identifier' => $payload['identifier'],
        'incident_type_id' => $incidentType->id,
    ]);
});

it('requires all fields', function (string $field) {
    $incidentType = IncidentType::factory()->create();

    $payload = [
        'description' => 'A car crash on the highway',
        'phoneNumber' => '+1234567890',
        'identifier' => 'INC-001',
        'incidentTypeId' => $incidentType->id,
        'latitude' => 36.1901230,
        'longitude' => 44.0091150,
    ];

    unset($payload[$field]);

    $this->postJson(route('incidents.store'), $payload)
        ->assertUnprocessable()
        ->assertJsonValidationErrors($field);
})->with([
    'description',
    'phoneNumber',
    'identifier',
    'incidentTypeId',
    'latitude',
    'longitude',
]);

it('rejects an invalid incident type', function () {
    $payload = [
        'description' => 'Something happened',
        'phoneNumber' => '+1234567890',
        'identifier' => 'INC-002',
        'incidentTypeId' => 999,
        'latitude' => 36.1901230,
        'longitude' => 44.0091150,
    ];

    $this->postJson(route('incidents.store'), $payload)
        ->assertUnprocessable()
        ->assertJsonValidationErrors('incidentTypeId');
});

it('accepts all valid incident types', function () {
    $incidentTypes = IncidentType::factory()->count(3)->create();

    foreach ($incidentTypes as $incidentType) {
        $payload = [
            'description' => 'An incident',
            'phoneNumber' => '+1234567890',
            'identifier' => fake()->uuid(),
            'incidentTypeId' => $incidentType->id,
            'latitude' => 36.1901230,
            'longitude' => 44.0091150,
        ];

        $this->postJson(route('incidents.store'), $payload)
            ->assertSuccessful();
    }
});

it('does not require authentication', function () {
    $incidentType = IncidentType::factory()->create();

    $payload = [
        'description' => 'Fire in the building',
        'phoneNumber' => '+1234567890',
        'identifier' => 'INC-004',
        'incidentTypeId' => $incidentType->id,
        'latitude' => 36.1901230,
        'longitude' => 44.0091150,
    ];

    $this->postJson(route('incidents.store'), $payload)
        ->assertSuccessful();
});
