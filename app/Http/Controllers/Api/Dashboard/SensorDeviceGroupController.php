<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Actions\Dashboard\ListSensorDeviceGroupsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\SensorDeviceGroupResource;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

#[Group('Dashboard')]
class SensorDeviceGroupController extends Controller
{
    public function index(ListSensorDeviceGroupsAction $action): AnonymousResourceCollection
    {
        return SensorDeviceGroupResource::collection($action->execute());
    }
}
