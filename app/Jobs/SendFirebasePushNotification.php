<?php

namespace App\Jobs;

use App\Services\FirebaseNotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SendFirebasePushNotification implements ShouldQueue
{
    use Queueable;

    /**
     * @param array<string, string> $titles
     * @param array<string, string> $bodies
     * @param array<string, string> $data
     */
    public function __construct(
        public array $titles,
        public array $bodies,
        public array $data = [],
    )
    {
    }

    public function handle(FirebaseNotificationService $service): void
    {
        $title = $this->titles['ku'] ?? '';
        $body = $this->bodies['ku'] ?? '';

        try {
            $service->sendToTopic('all', $title, $body, $this->data);
        } catch (\Throwable $e) {
            Log::error("Failed to send push notification to topic all: {$e->getMessage()}");
        }

        $topics = ['all-en' => 'en', 'all-ar' => 'ar', 'all-ku' => 'ku'];

//        foreach ($topics as $topic => $locale) {
//            $title = $this->titles[$locale] ?? $this->titles['en'] ?? '';
//            $body = $this->bodies[$locale] ?? $this->bodies['en'] ?? '';
//
//            try {
//                $service->sendToTopic($topic, $title, $body, $this->data);
//            } catch (\Throwable $e) {
//                Log::error("Failed to send push notification to topic {$topic}: {$e->getMessage()}");
//            }
//        }
    }
}
