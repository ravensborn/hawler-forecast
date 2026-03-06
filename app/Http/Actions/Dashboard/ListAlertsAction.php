<?php

namespace App\Http\Actions\Dashboard;

use App\Models\Alert;
use Illuminate\Pagination\LengthAwarePaginator;

class ListAlertsAction
{
    public function execute(): LengthAwarePaginator
    {
        return Alert::query()->latest()->paginate(5);
    }
}
