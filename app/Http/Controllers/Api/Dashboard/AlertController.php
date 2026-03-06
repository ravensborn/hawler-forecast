<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Actions\Dashboard\ListAlertsAction;
use App\Http\Actions\Dashboard\StoreAlertAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\StoreAlertRequest;
use App\Http\Resources\Dashboard\AlertCollection;
use App\Http\Resources\Dashboard\AlertResource;
use Dedoc\Scramble\Attributes\Group;

#[Group('Dashboard')]
class AlertController extends Controller
{
    public function index(ListAlertsAction $action): AlertCollection
    {
        return new AlertCollection($action->execute());
    }

    public function store(StoreAlertRequest $request, StoreAlertAction $action): AlertResource
    {
        return new AlertResource($action->execute($request));
    }
}
