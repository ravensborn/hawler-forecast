<?php

namespace App\Http\Resources\Dashboard;

use App\Enums\MapPinType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MapPinResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'icon' => $this->icon,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'type' => $this->type,
            'data' => $this->resolveData(),
            'createdAt' => $this->created_at,
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function resolveData(): ?array
    {
        $data = $this->data ?? [];

        if (in_array($this->type, [MapPinType::Alert, MapPinType::Incident])) {
            $data['severity'] = $this->severity;
        }

        if ($this->type === MapPinType::WeatherStation && $this->relationLoaded('sensorDeviceGroup') && $this->sensorDeviceGroup) {
            $data['sensorDeviceGroup'] = (new SensorDeviceGroupResource($this->sensorDeviceGroup))->resolve();
        }

        return empty($data) ? null : $data;
    }
}
