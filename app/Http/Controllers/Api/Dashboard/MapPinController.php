<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Enums\MapPinType;
use App\Http\Actions\Dashboard\DeleteMapPinAction;
use App\Http\Actions\Dashboard\ListMapPinsAction;
use App\Http\Actions\Dashboard\StoreMapPinAction;
use App\Http\Actions\Dashboard\UpdateMapPinAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreMapPinRequest;
use App\Http\Requests\Dashboard\UpdateMapPinRequest;
use App\Http\Resources\Dashboard\MapPinResource;
use App\Models\MapPin;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

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

    public function update(UpdateMapPinRequest $request, MapPin $mapPin, UpdateMapPinAction $action): MapPinResource
    {
        $this->ensureModifiable($mapPin);

        return new MapPinResource($action->execute($mapPin, $request));
    }

    public function destroy(MapPin $mapPin, DeleteMapPinAction $action): Response
    {
        $this->ensureModifiable($mapPin);

        $action->execute($mapPin);

        return response()->noContent();
    }

    private function ensureModifiable(MapPin $mapPin): void
    {
        if ($mapPin->type === MapPinType::WeatherStation) {
            throw new HttpException(403, 'Weather station pins cannot be modified.');
        }
    }
}
