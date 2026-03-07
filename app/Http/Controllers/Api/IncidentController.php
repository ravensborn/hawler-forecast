<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreIncidentRequest;
use App\Http\Resources\IncidentResource;
use App\Models\Incident;
use Dedoc\Scramble\Attributes\Group;

#[Group('App')]
class IncidentController extends Controller
{
    public function store(StoreIncidentRequest $request): IncidentResource
    {
        $incident = Incident::query()->create($request->databaseAttributes());

        return new IncidentResource($incident);
    }
}
