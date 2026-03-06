<?php

namespace App\Http\Actions\Dashboard;

use App\Http\Requests\Dashboard\StoreAlertRequest;
use App\Models\Alert;

class StoreAlertAction
{
    public function execute(StoreAlertRequest $request): Alert
    {
        return Alert::query()->create($request->validated());
    }
}
