<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Actions\Dashboard\ListMapPinsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\MapPinResource;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

#[Group('Dashboard')]
class MapPinController extends Controller
{
    public function index(ListMapPinsAction $action): AnonymousResourceCollection
    {
        return MapPinResource::collection($action->execute());
    }
}
