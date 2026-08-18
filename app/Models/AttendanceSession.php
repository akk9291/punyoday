<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttendanceSession extends Model
{
    use HasFactory;

    protected $fillable = ['shivir_id', 'session_name', 'session_date', 'type', 'is_active'];

    protected $casts = [
        'session_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function shivir(): BelongsTo
    {
        return $this->belongsTo(Shivir::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
