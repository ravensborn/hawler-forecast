<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TelemetryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'value' => $this->value,
            'updatedAt' => $this->created_at,
            'parameterName' => $this->sensorParameter->name,
            'parameterUnit' => $this->sensorParameter->unit,
            'parameterIcon' => $this->sensorParameter->icon,
        ];
    }
}
