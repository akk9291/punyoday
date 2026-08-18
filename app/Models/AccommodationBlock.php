<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccommodationBlock extends Model
{
    use HasFactory;

    protected $fillable = ['shivir_id', 'name', 'description'];

    public function shivir(): BelongsTo
    {
        return $this->belongsTo(Shivir::class);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(AccommodationRoom::class);
    }
}
