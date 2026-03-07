<?php

namespace App\Http\Actions\Dashboard;

use App\Http\Requests\Dashboard\UpdateMapPinRequest;
use App\Models\MapPin;

class UpdateMapPinAction
{
    public function execute(MapPin $mapPin, UpdateMapPinRequest $request): MapPin
    {
        $mapPin->update($request->validated());

        return $mapPin->refresh();
    }
}
