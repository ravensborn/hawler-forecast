<?php

namespace App\Http\Resources\Dashboard;

use App\Enums\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SensorDeviceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->getTranslation('name', Language::Kurdish->value),
            'latestTelemetry' => TelemetryResource::collection($this->whenLoaded('latestTelemetries')),
        ];
    }
}
