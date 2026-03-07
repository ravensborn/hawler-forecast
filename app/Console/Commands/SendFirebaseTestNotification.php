<?php

namespace App\Console\Commands;

use App\Services\FirebaseNotificationService;
use Illuminate\Console\Command;

class SendFirebaseTestNotification extends Command
{
    protected $signature = 'firebase:test-notification {topic : The topic to send the notification to}';

    protected $description = 'Send a test Firebase notification to a topic';

    public function handle(FirebaseNotificationService $service): void
    {
        $topic = $this->argument('topic');

        $this->info("Sending test notification to topic: {$topic}");

        try {
            $result = $service->sendToTopic(
                topic: $topic,
                title: 'Test Notification',
                body: 'This is a test notification from ' . config('app.name'),
            );

            $this->info('Notification sent successfully.');
            $this->line('Response: ' . json_encode($result));
        } catch (\Throwable $e) {
            $this->error("Failed to send notification: {$e->getMessage()}");
        }
    }
}
