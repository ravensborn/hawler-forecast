<?php

use App\Enums\MapPinType;
use App\Models\MapPin;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('returns an empty list when no map pins exist', function () {
    $this->getJson(route('map-pins.index'))
        ->assertSuccessful()
        ->assertJsonCount(0, 'data');
});

it('returns a list of map pins', function () {
    MapPin::factory(3)->create();

    $this->getJson(route('map-pins.index'))
        ->assertSuccessful()
        ->assertJsonCount(3, 'data');
});

it('returns the correct json structure', function () {
    MapPin::factory()->create();

    $this->getJson(route('map-pins.index'))
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

    $response = $this->getJson(route('map-pins.index'))
        ->assertSuccessful();

    $types = collect($response->json('data'))->pluck('type')->unique()->values();

    expect($types->toArray())->each->toBeIn(MapPinType::values());
});

it('does not require authentication', function () {
    $this->getJson(route('map-pins.index'))
        ->assertSuccessful();
});

it('returns null data field when data is null on weather station', function () {
    MapPin::factory()->weatherStation()->create(['data' => null]);

    $response = $this->getJson(route('map-pins.index'))
        ->assertSuccessful();

    expect($response->json('data.0.data'))->toBeNull();
});

it('excludes expired pins from results', function () {
    MapPin::factory()->create(['expires_at' => now()->subDay()]);
    MapPin::factory()->create(['expires_at' => null]);

    $this->getJson(route('map-pins.index'))
        ->assertSuccessful()
        ->assertJsonCount(1, 'data');
});

it('includes non-expired and null-expiry pins', function () {
    MapPin::factory()->create(['expires_at' => null]);
    MapPin::factory()->create(['expires_at' => now()->addDay()]);
    MapPin::factory()->expired()->create();

    $this->getJson(route('map-pins.index'))
        ->assertSuccessful()
        ->assertJsonCount(2, 'data');
});

it('alert pins have severity and multilingual messages', function () {
    $pin = MapPin::factory()->alert()->create();

    expect($pin->severity)->not->toBeNull()
        ->and($pin->data)->toHaveKey('message')
        ->and($pin->data['message'])->toBeArray()
        ->and($pin->data['message'])->toHaveKeys(['en', 'ar', 'ku']);
});

it('returns valid map pin type values including incident', function () {
    MapPin::factory()->weatherStation()->create();
    MapPin::factory()->alert()->create();
    MapPin::factory()->incident()->create();

    $response = $this->getJson(route('map-pins.index'))
        ->assertSuccessful();

    $types = collect($response->json('data'))->pluck('type')->unique()->values();

    expect($types->toArray())->each->toBeIn(MapPinType::values());
});

it('incident pins have severity and multilingual messages', function () {
    $pin = MapPin::factory()->incident()->create();

    expect($pin->severity)->not->toBeNull()
        ->and($pin->data)->toHaveKey('message')
        ->and($pin->data['message'])->toBeArray()
        ->and($pin->data['message'])->toHaveKeys(['en', 'ar', 'ku']);
});

it('returns incident pin message in the requested language', function () {
    MapPin::factory()->incident()->create([
        'data' => ['message' => ['en' => 'Road closure', 'ar' => 'إغلاق الطريق', 'ku' => 'داخستنی ڕێگا']],
    ]);

    $enPin = $this->getJson(route('map-pins.index', ['language' => 'en']))->json('data.0');
    $arPin = $this->getJson(route('map-pins.index', ['language' => 'ar']))->json('data.0');

    expect($enPin['data']['message'])->toBe('Road closure')
        ->and($arPin['data']['message'])->toBe('إغلاق الطريق');
});

it('returns alert pin message in the requested language', function () {
    MapPin::factory()->alert()->create([
        'data' => ['message' => ['en' => 'High temperature', 'ar' => 'درجة حرارة عالية', 'ku' => 'گەرمای بەرز']],
    ]);

    $enPin = $this->getJson(route('map-pins.index', ['language' => 'en']))->json('data.0');
    $arPin = $this->getJson(route('map-pins.index', ['language' => 'ar']))->json('data.0');

    expect($enPin['data']['message'])->toBe('High temperature')
        ->and($arPin['data']['message'])->toBe('درجة حرارة عالية');
});
