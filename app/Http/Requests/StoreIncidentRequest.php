<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'description' => ['required', 'string'],
            'phoneNumber' => ['required', 'string', 'starts_with:07', 'size:11'],
            'identifier' => ['required', 'string'],
            'incidentTypeId' => ['required', 'integer', 'exists:incident_types,id'],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
        ];
    }

    /**
     * Get the validated data mapped to snake_case for the database.
     *
     * @return array<string, mixed>
     */
    public function databaseAttributes(): array
    {
        $validated = $this->validated();

        return [
            'description' => $validated['description'],
            'phone_number' => $validated['phoneNumber'],
            'identifier' => $validated['identifier'],
            'incident_type_id' => $validated['incidentTypeId'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
        ];
    }
}
