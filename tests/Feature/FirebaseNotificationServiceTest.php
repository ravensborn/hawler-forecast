<?php

use App\Services\FirebaseNotificationService;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Messaging\CloudMessage;

use function Pest\Laravel\mock;

it('sends a notification to a topic', function () {
    $messaging = mock(Messaging::class);

    $messaging->shouldReceive('send')
        ->once()
        ->withArgs(function (CloudMessage $message) {
            $payload = $message->jsonSerialize();

            return $payload['topic'] === 'test-topic'
                && $payload['notification']['title'] === 'Hello'
                && $payload['notification']['body'] === 'World';
        })
        ->andReturn(['name' => 'projects/test/messages/123']);

    $service = new FirebaseNotificationService($messaging);

    $result = $service->sendToTopic('test-topic', 'Hello', 'World');

    expect($result)->toBe(['name' => 'projects/test/messages/123']);
});

it('sends a notification with additional data', function () {
    $messaging = mock(Messaging::class);

    $messaging->shouldReceive('send')
        ->once()
        ->withArgs(function (CloudMessage $message) {
            $payload = $message->jsonSerialize();

            return $payload['topic'] === 'alerts'
                && $payload['data']['key'] === 'value';
        })
        ->andReturn(['name' => 'projects/test/messages/456']);

    $service = new FirebaseNotificationService($messaging);

    $result = $service->sendToTopic('alerts', 'Title', 'Body', ['key' => 'value']);

    expect($result)->toBe(['name' => 'projects/test/messages/456']);
});

it('sends a notification without data when none provided', function () {
    $messaging = mock(Messaging::class);

    $messaging->shouldReceive('send')
        ->once()
        ->withArgs(function (CloudMessage $message) {
            $payload = $message->jsonSerialize();

            return ! isset($payload['data']);
        })
        ->andReturn(['name' => 'projects/test/messages/789']);

    $service = new FirebaseNotificationService($messaging);

    $service->sendToTopic('news', 'Title', 'Body');
});
