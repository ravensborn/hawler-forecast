<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Actions\Dashboard\ListIncidentsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Dashboard\IncidentCollection;
use Dedoc\Scramble\Attributes\Group;

#[Group('Dashboard')]
class IncidentController extends Controller
{
    public function index(ListIncidentsAction $action): IncidentCollection
    {
        return new IncidentCollection($action->execute());
    }
}
