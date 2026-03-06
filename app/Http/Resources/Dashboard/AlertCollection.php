<?php

namespace App\Http\Resources\Dashboard;

class AlertCollection extends PaginatedCollection
{
    public $collects = AlertResource::class;
}
