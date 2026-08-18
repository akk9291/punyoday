<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AccommodationBed extends Model
{
    use HasFactory;

    protected $fillable = ['accommodation_room_id', 'bed_number', 'is_occupied'];

    protected $casts = [
        'is_occupied' => 'boolean',
    ];

    public function room(): BelongsTo
    {
        return $this->belongsTo(AccommodationRoom::class, 'accommodation_room_id');
    }

    public function allocation(): HasOne
    {
        return $this->hasOne(RoomAllocation::class);
    }
}
