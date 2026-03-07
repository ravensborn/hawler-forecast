<?php

use App\Jobs\SendFirebasePushNotification;
use Illuminate\Support\Facades\Queue;

it('is a queued job', function () {
    expect(SendFirebasePushNotification::class)
        ->toImplement(\Illuminate\Contracts\Queue\ShouldQueue::class);
});

it('stores titles and bodies for all languages', function () {
    Queue::fake();

    $titles = ['en' => 'Alert', 'ar' => 'تنبيه', 'ku' => 'ئاگادارکردنەوە'];
    $bodies = ['en' => 'High temperature', 'ar' => 'درجة حرارة عالية', 'ku' => 'گەرمای بەرز'];
    $data = ['type' => 'alert', 'id' => '1'];

    SendFirebasePushNotification::dispatch($titles, $bodies, $data);

    Queue::assertPushed(SendFirebasePushNotification::class, function ($job) {
        return $job->titles['en'] === 'Alert'
            && $job->titles['ar'] === 'تنبيه'
            && $job->titles['ku'] === 'ئاگادارکردنەوە'
            && $job->bodies['en'] === 'High temperature'
            && $job->data['type'] === 'alert';
    });
});
