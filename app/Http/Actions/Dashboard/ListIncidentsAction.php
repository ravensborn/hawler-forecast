<?php

namespace App\Http\Actions\Dashboard;

use App\Models\Incident;
use Illuminate\Pagination\LengthAwarePaginator;

class ListIncidentsAction
{
    public function execute(): LengthAwarePaginator
    {
        return Incident::query()->with('incidentType')->latest()->paginate(10);
    }
}
