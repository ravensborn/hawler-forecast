<?php

namespace App\Http\Resources\Dashboard;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlertResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'icon' => $this->icon,
            'title' => [
                'en' => $this->getTranslation('title', 'en'),
                'ar' => $this->getTranslation('title', 'ar'),
                'ku' => $this->getTranslation('title', 'ku'),
            ],
            'description' => [
                'en' => $this->getTranslation('description', 'en'),
                'ar' => $this->getTranslation('description', 'ar'),
                'ku' => $this->getTranslation('description', 'ku'),
            ],
            'type' => $this->type,
            'createdAt' => $this->created_at,
        ];
    }
}
