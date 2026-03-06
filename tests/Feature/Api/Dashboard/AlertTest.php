<?php

use App\Enums\AlertType;
use App\Models\Alert;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('requires authentication', function () {
    $this->getJson(route('dashboard.alerts.index'))->assertUnauthorized();
    $this->postJson(route('dashboard.alerts.store'))->assertUnauthorized();
});

it('returns a paginated list of alerts', function () {
    Alert::factory(3)->create();

    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.alerts.index'))
        ->assertSuccessful()
        ->assertJsonCount(3, 'data')
        ->assertJsonStructure(['data', 'meta']);
});

it('paginates 10 alerts per page', function () {
    Alert::factory(15)->create();

    $response = $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.alerts.index'))
        ->assertSuccessful()
        ->assertJsonCount(10, 'data');

    expect($response->json('meta.perPage'))->toBe(10)
        ->and($response->json('meta.total'))->toBe(15);
});

it('returns an empty list when no alerts exist', function () {
    $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.alerts.index'))
        ->assertSuccessful()
        ->assertJsonCount(0, 'data');
});

it('returns alerts ordered by newest first', function () {
    $old = Alert::factory()->create(['created_at' => now()->subDay()]);
    $new = Alert::factory()->create(['created_at' => now()]);

    $response = $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.alerts.index'))
        ->assertSuccessful();

    $ids = collect($response->json('data'))->pluck('id');

    expect($ids->first())->toBe($new->id)
        ->and($ids->last())->toBe($old->id);
});

it('returns all translations in the list', function () {
    Alert::factory()->create([
        'title' => ['en' => 'English Title', 'ar' => 'عنوان عربي', 'ku' => 'ناونیشانی کوردی'],
        'description' => ['en' => 'English description', 'ar' => 'وصف عربي', 'ku' => 'وەسفی کوردی'],
    ]);

    $alert = $this->actingAs(User::factory()->create())
        ->getJson(route('dashboard.alerts.index'))
        ->assertSuccessful()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'icon',
                    'title' => ['en', 'ar', 'ku'],
                    'description' => ['en', 'ar', 'ku'],
                    'type',
                    'createdAt',
                ],
            ],
        ])
        ->json('data.0');

    expect($alert['title']['en'])->toBe('English Title')
        ->and($alert['title']['ar'])->toBe('عنوان عربي')
        ->and($alert['title']['ku'])->toBe('ناونیشانی کوردی');
});

it('creates an alert successfully', function () {
    $payload = [
        'icon' => 'bell',
        'title' => ['en' => 'Fire Alert', 'ar' => 'تنبيه حريق', 'ku' => 'ئاگاداری ئاگر'],
        'description' => ['en' => 'Fire detected', 'ar' => 'تم اكتشاف حريق', 'ku' => 'ئاگر دۆزرایەوە'],
        'type' => AlertType::Danger->value,
    ];

    $this->actingAs(User::factory()->create())
        ->postJson(route('dashboard.alerts.store'), $payload)
        ->assertCreated()
        ->assertJsonStructure([
            'data' => [
                'id', 'icon',
                'title' => ['en', 'ar', 'ku'],
                'description' => ['en', 'ar', 'ku'],
                'type', 'createdAt',
            ],
        ])
        ->assertJsonPath('data.title.en', $payload['title']['en'])
        ->assertJsonPath('data.type', AlertType::Danger->value);

    $this->assertDatabaseHas('alerts', ['icon' => 'bell']);
});

it('requires all fields to create an alert', function (string $field) {
    $payload = [
        'icon' => 'bell',
        'title' => ['en' => 'Title EN', 'ar' => 'Title AR', 'ku' => 'Title KU'],
        'description' => ['en' => 'Desc EN', 'ar' => 'Desc AR', 'ku' => 'Desc KU'],
        'type' => AlertType::Info->value,
    ];

    data_forget($payload, $field);

    $this->actingAs(User::factory()->create())
        ->postJson(route('dashboard.alerts.store'), $payload)
        ->assertUnprocessable()
        ->assertJsonValidationErrors($field);
})->with([
    'icon',
    'title.en',
    'title.ar',
    'title.ku',
    'description.en',
    'description.ar',
    'description.ku',
    'type',
]);

it('rejects an invalid alert type', function () {
    $payload = [
        'icon' => 'bell',
        'title' => ['en' => 'Title EN', 'ar' => 'Title AR', 'ku' => 'Title KU'],
        'description' => ['en' => 'Desc EN', 'ar' => 'Desc AR', 'ku' => 'Desc KU'],
        'type' => 'invalid-type',
    ];

    $this->actingAs(User::factory()->create())
        ->postJson(route('dashboard.alerts.store'), $payload)
        ->assertUnprocessable()
        ->assertJsonValidationErrors('type');
});
