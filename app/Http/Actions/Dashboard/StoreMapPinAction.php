<?php

namespace App\Http\Actions\Dashboard;

use App\Http\Requests\Dashboard\StoreMapPinRequest;
use App\Jobs\SendFirebasePushNotification;
use App\Models\MapPin;

class StoreMapPinAction
{
    public function execute(StoreMapPinRequest $request): MapPin
    {
        $mapPin = MapPin::query()->create($request->validated());

        $messages = $mapPin->data['message'] ?? [];

        if ($messages !== []) {
            SendFirebasePushNotification::dispatch(
                titles: [
                    'en' => $mapPin->type->value,
                    'ar' => $mapPin->type->value,
                    'ku' => $mapPin->type->value,
                ],
                bodies: $messages,
                data: [
                    'type' => $mapPin->type->value,
                    'map_pin_id' => (string) $mapPin->id,
                ],
            );
        }

        return $mapPin;
    }
}
