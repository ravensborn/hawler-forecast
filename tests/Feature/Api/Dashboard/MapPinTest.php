<?php

use App\Enums\MapPinType;
use App\Models\MapPin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('requires authentication', function () {
    $this->getJson(route('dashboard.map-pins.index'))
        ->assertUnauthorized();
});

it('returns an empty list when no map pins exist', function () {
    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.map-pins.index'))
        ->assertSuccessful()
        ->assertJsonCount(0, 'data');
});

it('returns a list of map pins', function () {
    MapPin::factory(3)->create();

    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.map-pins.index'))
        ->assertSuccessful()
        ->assertJsonCount(3, 'data');
});

it('returns the correct json structure', function () {
    MapPin::factory()->create();

    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.map-pins.index'))
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'icon',
                    'latitude',
                    'longitude',
                    'type',
                    'data',
                    'createdAt',
                ],
            ],
        ]);
});

it('returns valid map pin type values', function () {
    MapPin::factory()->weatherStation()->create();
    MapPin::factory()->alert()->create();
    MapPin::factory()->incident()->create();

    $response = $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.map-pins.index'))
        ->assertSuccessful();

    $types = collect($response->json('data'))->pluck('type')->unique()->values();

    expect($types->toArray())->each->toBeIn(MapPinType::values());
});

it('excludes expired pins from results', function () {
    MapPin::factory()->create(['expires_at' => now()->subDay()]);
    MapPin::factory()->create(['expires_at' => null]);

    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.map-pins.index'))
        ->assertSuccessful()
        ->assertJsonCount(1, 'data');
});

it('returns all language translations in message data', function () {
    MapPin::factory()->alert()->create([
        'data' => ['severity' => 'high', 'message' => ['en' => 'High temperature', 'ar' => 'درجة حرارة عالية', 'ku' => 'گەرمای بەرز']],
    ]);

    $pin = $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.map-pins.index'))
        ->assertSuccessful()
        ->json('data.0');

    expect($pin['data']['message'])->toBeArray()
        ->toHaveKeys(['en', 'ar', 'ku']);
});
