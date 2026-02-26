<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\IncidentTypeResource;
use App\Models\IncidentType;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class IncidentTypeController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return IncidentTypeResource::collection(IncidentType::all());
    }
}
