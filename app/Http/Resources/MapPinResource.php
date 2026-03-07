<?php

namespace App\Http\Resources;

use App\Enums\MapPinType;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MapPinResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
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

        if (isset($data['message']) && is_array($data['message'])) {
            $locale = app()->getLocale();
            $data['message'] = $data['message'][$locale] ?? $data['message'][config('app.fallback_locale')] ?? null;
        }

        if ($this->type === MapPinType::WeatherStation && $this->relationLoaded('sensorDeviceGroup') && $this->sensorDeviceGroup) {
            $data['sensorDeviceGroup'] = (new SensorDeviceGroupResource($this->sensorDeviceGroup))->resolve();
        }

        return empty($data) ? null : $data;
    }
}
