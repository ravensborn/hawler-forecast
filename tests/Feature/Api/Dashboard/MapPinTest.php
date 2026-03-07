<?php

use App\Enums\MapPinType;
use App\Jobs\SendFirebasePushNotification;
use App\Models\MapPin;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;

uses(RefreshDatabase::class);

it('requires authentication', function () {
    $this->getJson(route('dashboard.map-pins.index'))
        ->assertUnauthorized();

    $this->postJson(route('dashboard.map-pins.store'))
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
        'data' => ['message' => ['en' => 'High temperature', 'ar' => 'درجة حرارة عالية', 'ku' => 'گەرمای بەرز']],
    ]);

    $pin = $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.map-pins.index'))
        ->assertSuccessful()
        ->json('data.0');

    expect($pin['data']['message'])->toBeArray()
        ->toHaveKeys(['en', 'ar', 'ku']);
});

it('creates a map pin with alert type', function () {
    Queue::fake();

    $this->actingAs(User::factory()->create())
        ->postJson(route('dashboard.map-pins.store'), [
            'icon' => 'warning',
            'latitude' => 36.1994,
            'longitude' => 44.0220,
            'type' => 'alert',
            'severity' => 'high',
            'data' => [
                'message' => [
                    'en' => 'Flood warning in the area',
                    'ar' => 'تحذير من فيضان في المنطقة',
                    'ku' => 'ئاگاداری لافاو لە ناوچەکە',
                ],
            ],
            'expires_at' => now()->addDays(3)->toISOString(),
        ])
        ->assertSuccessful()
        ->assertJsonPath('type', 'alert')
        ->assertJsonPath('data.severity', 'high')
        ->assertJsonPath('data.message.en', 'Flood warning in the area');

    expect(MapPin::count())->toBe(1);
});

it('creates a map pin with incident type', function () {
    Queue::fake();

    $this->actingAs(User::factory()->create())
        ->postJson(route('dashboard.map-pins.store'), [
            'icon' => 'fire',
            'latitude' => 36.15,
            'longitude' => 44.01,
            'type' => 'incident',
            'severity' => 'medium',
            'data' => [
                'message' => [
                    'en' => 'Fire reported',
                    'ar' => 'تم الإبلاغ عن حريق',
                    'ku' => 'ئاگر ڕاپۆرت کراوە',
                ],
            ],
            'expires_at' => null,
        ])
        ->assertSuccessful()
        ->assertJsonPath('type', 'incident')
        ->assertJsonPath('data.severity', 'medium');
});

it('rejects weather-station type', function () {
    $this->actingAs(User::factory()->create())
        ->postJson(route('dashboard.map-pins.store'), [
            'icon' => 'station',
            'latitude' => 36.15,
            'longitude' => 44.01,
            'type' => 'weather-station',
            'severity' => 'low',
            'data' => [
                'message' => ['en' => 'test', 'ar' => 'test', 'ku' => 'test'],
            ],
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors('type');
});

it('requires all three languages in message', function () {
    $this->actingAs(User::factory()->create())
        ->postJson(route('dashboard.map-pins.store'), [
            'icon' => 'warning',
            'latitude' => 36.15,
            'longitude' => 44.01,
            'type' => 'alert',
            'severity' => 'high',
            'data' => [
                'message' => ['en' => 'English only'],
            ],
        ])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['data.message.ar', 'data.message.ku']);
});

it('requires all fields', function () {
    $this->actingAs(User::factory()->create())
        ->postJson(route('dashboard.map-pins.store'), [])
        ->assertUnprocessable()
        ->assertJsonValidationErrors(['icon', 'latitude', 'longitude', 'type', 'severity', 'data']);
});

it('updates an alert map pin', function () {
    $pin = MapPin::factory()->alert()->create();

    $this->actingAs(User::factory()->create())
        ->putJson(route('dashboard.map-pins.update', $pin), [
            'icon' => 'updated-icon',
            'severity' => 'low',
            'data' => [
                'message' => [
                    'en' => 'Updated message',
                    'ar' => 'رسالة محدثة',
                    'ku' => 'نامەی نوێکراوە',
                ],
            ],
        ])
        ->assertSuccessful()
        ->assertJsonPath('icon', 'updated-icon')
        ->assertJsonPath('data.severity', 'low')
        ->assertJsonPath('data.message.en', 'Updated message');
});

it('updates an incident map pin', function () {
    $pin = MapPin::factory()->incident()->create();

    $this->actingAs(User::factory()->create())
        ->putJson(route('dashboard.map-pins.update', $pin), [
            'severity' => 'high',
        ])
        ->assertSuccessful()
        ->assertJsonPath('data.severity', 'high');
});

it('cannot update a weather station pin', function () {
    $pin = MapPin::factory()->weatherStation()->create();

    $this->actingAs(User::factory()->create())
        ->putJson(route('dashboard.map-pins.update', $pin), [
            'icon' => 'new-icon',
        ])
        ->assertForbidden();
});

it('deletes an alert map pin', function () {
    $pin = MapPin::factory()->alert()->create();

    $this->actingAs(User::factory()->create())
        ->deleteJson(route('dashboard.map-pins.destroy', $pin))
        ->assertNoContent();

    expect(MapPin::count())->toBe(0);
});

it('deletes an incident map pin', function () {
    $pin = MapPin::factory()->incident()->create();

    $this->actingAs(User::factory()->create())
        ->deleteJson(route('dashboard.map-pins.destroy', $pin))
        ->assertNoContent();

    expect(MapPin::count())->toBe(0);
});

it('cannot delete a weather station pin', function () {
    $pin = MapPin::factory()->weatherStation()->create();

    $this->actingAs(User::factory()->create())
        ->deleteJson(route('dashboard.map-pins.destroy', $pin))
        ->assertForbidden();

    expect(MapPin::count())->toBe(1);
});

it('dispatches push notification when creating a map pin', function () {
    Queue::fake();

    $this->actingAs(User::factory()->create())
        ->postJson(route('dashboard.map-pins.store'), [
            'icon' => 'warning',
            'latitude' => 36.1994,
            'longitude' => 44.0220,
            'type' => 'alert',
            'severity' => 'high',
            'data' => [
                'message' => [
                    'en' => 'Flood warning',
                    'ar' => 'تحذير من فيضان',
                    'ku' => 'ئاگاداری لافاو',
                ],
            ],
            'expires_at' => now()->addDays(3)->toISOString(),
        ])
        ->assertSuccessful();

    Queue::assertPushed(SendFirebasePushNotification::class, function ($job) {
        return $job->bodies['en'] === 'Flood warning'
            && $job->bodies['ar'] === 'تحذير من فيضان'
            && $job->bodies['ku'] === 'ئاگاداری لافاو'
            && $job->data['type'] === 'alert';
    });
});

it('requires authentication for update and delete', function () {
    $pin = MapPin::factory()->alert()->create();

    $this->putJson(route('dashboard.map-pins.update', $pin))
        ->assertUnauthorized();

    $this->deleteJson(route('dashboard.map-pins.destroy', $pin))
        ->assertUnauthorized();
});
