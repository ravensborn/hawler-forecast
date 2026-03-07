<?php

namespace App\Http\Requests\Dashboard;

use App\Enums\MapPinType;
use App\Enums\Severity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMapPinRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'icon' => ['sometimes', 'string'],
            'latitude' => ['sometimes', 'numeric', 'between:-90,90'],
            'longitude' => ['sometimes', 'numeric', 'between:-180,180'],
            'type' => ['sometimes', Rule::in([MapPinType::Alert->value, MapPinType::Incident->value])],
            'severity' => ['sometimes', Rule::enum(Severity::class)],
            'data' => ['sometimes', 'array'],
            'data.message' => ['required_with:data', 'array'],
            'data.message.en' => ['required_with:data', 'string'],
            'data.message.ar' => ['required_with:data', 'string'],
            'data.message.ku' => ['required_with:data', 'string'],
            'expires_at' => ['nullable', 'date', 'after:now'],
        ];
    }
}
