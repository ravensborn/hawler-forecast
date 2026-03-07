<?php

namespace App\Http\Requests\Dashboard;

use App\Enums\MapPinType;
use App\Enums\Severity;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMapPinRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'icon' => ['required', 'string'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'type' => ['required', Rule::in([MapPinType::Alert->value, MapPinType::Incident->value])],
            'severity' => ['required', Rule::enum(Severity::class)],
            'data' => ['required', 'array'],
            'data.message' => ['required', 'array'],
            'data.message.en' => ['required', 'string'],
            'data.message.ar' => ['required', 'string'],
            'data.message.ku' => ['required', 'string'],
            'expires_at' => ['nullable', 'date', 'after:now'],
        ];
    }
}
