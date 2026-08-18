<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meal extends Model
{
    use HasFactory;

    protected $fillable = ['shivir_id', 'meal_name', 'meal_date'];

    protected $casts = [
        'meal_date' => 'date',
    ];

    public function shivir(): BelongsTo
    {
        return $this->belongsTo(Shivir::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(MealRecord::class);
    }
}
