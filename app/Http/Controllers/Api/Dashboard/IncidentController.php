<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Actions\Dashboard\ListIncidentsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\IncidentResource;
use Dedoc\Scramble\Attributes\Group;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

#[Group('Dashboard')]
class IncidentController extends Controller
{
    public function index(ListIncidentsAction $action): AnonymousResourceCollection
    {
        return IncidentResource::collection($action->execute());
    }
}
