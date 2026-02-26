<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Incident extends Model
{
    /** @use HasFactory<\Database\Factories\IncidentFactory> */
    use HasFactory;

    protected $fillable = [
        'description',
        'phone_number',
        'identifier',
        'incident_type_id',
        'latitude',
        'longitude',
    ];

    public function incidentType(): BelongsTo
    {
        return $this->belongsTo(IncidentType::class);
    }
}
