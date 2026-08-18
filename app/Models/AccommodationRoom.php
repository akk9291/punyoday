<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccommodationRoom extends Model
{
    use HasFactory;

    protected $fillable = ['accommodation_block_id', 'room_number', 'capacity', 'floor', 'notes'];

    public function block(): BelongsTo
    {
        return $this->belongsTo(AccommodationBlock::class, 'accommodation_block_id');
    }

    public function beds(): HasMany
    {
        return $this->hasMany(AccommodationBed::class);
    }
}
