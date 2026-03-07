<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlertResource;
use App\Models\Alert;
use Dedoc\Scramble\Attributes\Group;
use Dedoc\Scramble\Attributes\QueryParameter;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

#[Group('App')]
class AlertController extends Controller
{
    #[QueryParameter('language', description: 'The language code for translatable fields.', type: 'string', example: 'en')]
    public function index(): AnonymousResourceCollection
    {
        return AlertResource::collection(
            Alert::query()->latest()->get()
        );
    }
}
