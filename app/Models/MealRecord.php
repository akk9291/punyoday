<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MealRecord extends Model
{
    use HasFactory;

    protected $fillable = ['meal_id', 'registration_id', 'scanned_at', 'scanned_by'];

    protected $casts = [
        'scanned_at' => 'datetime',
    ];

    public function meal(): BelongsTo
    {
        return $this->belongsTo(Meal::class);
    }

    public function registration(): BelongsTo
    {
        return $this->belongsTo(Registration::class);
    }
}
