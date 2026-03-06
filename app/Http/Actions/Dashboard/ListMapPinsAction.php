<?php

namespace App\Http\Actions\Dashboard;

use App\Models\MapPin;
use Illuminate\Database\Eloquent\Collection;

class ListMapPinsAction
{
    public function execute(): Collection
    {
        return MapPin::query()
            ->with('sensorDeviceGroup.sensorDevices.latestTelemetries.sensorParameter')
            ->active()
            ->latest()
            ->get();
    }
}
