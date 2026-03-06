<?php

use App\Models\Incident;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('requires authentication', function () {
    $this->getJson(route('dashboard.incidents.index'))
        ->assertUnauthorized();
});

it('returns a paginated list of incidents', function () {
    Incident::factory(5)->create();

    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.incidents.index'))
        ->assertSuccessful()
        ->assertJsonCount(5, 'data')
        ->assertJsonStructure(['data', 'meta']);
});

it('paginates 10 incidents per page', function () {
    Incident::factory(15)->create();

    $response = $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.incidents.index'))
        ->assertSuccessful()
        ->assertJsonCount(10, 'data');

    expect($response->json('meta.perPage'))->toBe(10)
        ->and($response->json('meta.total'))->toBe(15);
});

it('returns an empty list when no incidents exist', function () {
    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.incidents.index'))
        ->assertSuccessful()
        ->assertJsonCount(0, 'data');
});

it('returns the correct json structure', function () {
    Incident::factory()->create();

    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.incidents.index'))
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'description',
                    'phoneNumber',
                    'identifier',
                    'incidentType',
                    'latitude',
                    'longitude',
                    'createdAt',
                ],
            ],
        ]);
});

it('returns incidents ordered by newest first', function () {
    $old = Incident::factory()->create(['created_at' => now()->subDay()]);
    $new = Incident::factory()->create(['created_at' => now()]);

    $response = $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.incidents.index'))
        ->assertSuccessful();

    $ids = collect($response->json('data'))->pluck('id');

    expect($ids->first())->toBe($new->id)
        ->and($ids->last())->toBe($old->id);
});
