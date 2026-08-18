<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TransportRoute extends Model
{
    use HasFactory;

    protected $fillable = ['shivir_id', 'vehicle_number', 'driver_name', 'driver_phone', 'pickup_point', 'capacity'];

    public function shivir(): BelongsTo
    {
        return $this->belongsTo(Shivir::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(TransportAssignment::class);
    }
}
