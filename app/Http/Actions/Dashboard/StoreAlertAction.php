<?php

namespace App\Http\Actions\Dashboard;

use App\Http\Requests\Dashboard\StoreAlertRequest;
use App\Jobs\SendFirebasePushNotification;
use App\Models\Alert;

class StoreAlertAction
{
    public function execute(StoreAlertRequest $request): Alert
    {
        $alert = Alert::query()->create($request->validated());

        SendFirebasePushNotification::dispatch(
            titles: $alert->getTranslations('title'),
            bodies: $alert->getTranslations('description'),
            data: [
                'type' => $alert->type->value,
                'alert_id' => (string) $alert->id,
            ],
        );

        return $alert;
    }
}
