<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShivirSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'shivir_id',
        'day_number',
        'date',
        'time_slot',
        'activity_name',
        'location_venue',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
    ];

    public function shivir(): BelongsTo
    {
        return $this->belongsTo(Shivir::class);
    }
}
