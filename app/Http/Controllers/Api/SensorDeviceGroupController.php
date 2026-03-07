<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SensorDeviceGroupResource;
use App\Models\SensorDeviceGroup;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

#[Group('App')]
class SensorDeviceGroupController extends Controller
{
    #[QueryParameter('language', description: 'The language code for translatable fields.', type: 'string', example: 'en')]
    public function index(): AnonymousResourceCollection
    {
        return SensorDeviceGroupResource::collection(
            SensorDeviceGroup::query()
                ->with('sensorDevices.latestTelemetries.sensorParameter')
                ->get()
        );
    }
}
