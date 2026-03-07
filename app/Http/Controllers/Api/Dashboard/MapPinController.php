<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Actions\Dashboard\ListMapPinsAction;
use App\Http\Actions\Dashboard\StoreMapPinAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreMapPinRequest;
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

    public function store(StoreMapPinRequest $request, StoreMapPinAction $action): MapPinResource
    {
        return new MapPinResource($action->execute($request));
    }
}
