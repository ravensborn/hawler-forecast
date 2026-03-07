<?php

namespace App\Http\Actions\Dashboard;

use App\Models\MapPin;

class DeleteMapPinAction
{
    public function execute(MapPin $mapPin): void
    {
        $mapPin->delete();
    }
}
