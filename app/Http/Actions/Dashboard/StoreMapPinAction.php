<?php

namespace App\Http\Actions\Dashboard;

use App\Http\Requests\Dashboard\StoreMapPinRequest;
use App\Models\MapPin;

class StoreMapPinAction
{
    public function execute(StoreMapPinRequest $request): MapPin
    {
        return MapPin::query()->create($request->validated());
    }
}
