<?php

namespace App\Http\Requests\Dashboard;

use App\Enums\AlertType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreAlertRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'icon' => ['required', 'string'],
            'title' => ['required', 'array'],
            'title.en' => ['required', 'string'],
            'title.ar' => ['required', 'string'],
            'title.ku' => ['required', 'string'],
            'description' => ['required', 'array'],
            'description.en' => ['required', 'string'],
            'description.ar' => ['required', 'string'],
            'description.ku' => ['required', 'string'],
            'type' => ['required', Rule::enum(AlertType::class)],
        ];
    }
}
