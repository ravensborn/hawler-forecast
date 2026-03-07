<?php

namespace App\Services;

use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotificationService
{
    public function __construct(private Messaging $messaging) {}

    /**
     * Send a notification to a Firebase topic.
     *
     * @param  array<string, string>  $data
     * @return array<string, mixed>
     */
    public function sendToTopic(string $topic, string $title, string $body, array $data = []): array
    {
        $message = CloudMessage::new()
            ->withTopic($topic)
            ->withNotification(Notification::fromArray([
                'title' => $title,
                'body' => $body,
            ]));

        if ($data !== []) {
            $message = $message->withData($data);
        }

        return $this->messaging->send($message);
    }
}
