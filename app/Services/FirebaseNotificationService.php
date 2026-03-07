<?php

namespace App\Services;

use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

readonly class FirebaseNotificationService
{
    public function __construct(private Messaging $messaging) {}

    /**
     * Send a notification to a Firebase topic.
     *
     * @param string $topic
     * @param string $title
     * @param string $body
     * @param array<string, string> $data
     * @return array<string, mixed>
     * @throws FirebaseException
     * @throws MessagingException
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
