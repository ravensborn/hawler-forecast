<?php

namespace App\Http\Resources\Dashboard;

class IncidentCollection extends PaginatedCollection
{
    public $collects = IncidentResource::class;
}
