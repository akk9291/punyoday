<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RoomAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'registration_id',
        'accommodation_bed_id',
        'allocated_at',
        'allocated_by',
        'notes',
    ];

    protected $casts = [
        'allocated_at' => 'datetime',
    ];

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }

    public function bed(): BelongsTo
    {
        return $this->belongsTo(AccommodationBed::class, 'accommodation_bed_id');
    }

    public function allocatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'allocated_by');
    }
}
