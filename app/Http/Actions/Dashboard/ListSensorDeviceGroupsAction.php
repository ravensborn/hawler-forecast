<?php

namespace App\Http\Actions\Dashboard;

use App\Models\SensorDeviceGroup;
use Illuminate\Database\Eloquent\Collection;

class ListSensorDeviceGroupsAction
{
    public function execute(): Collection
    {
        return SensorDeviceGroup::query()
            ->with('sensorDevices.latestTelemetries.sensorParameter')
            ->get();
    }
}
