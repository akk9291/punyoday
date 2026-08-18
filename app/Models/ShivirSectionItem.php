<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShivirSectionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'shivir_section_id',
        'name',
        'photo',
        'designation',
        'department',
        'mobile',
        'whatsapp',
        'address',
        'description',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(ShivirSection::class, 'shivir_section_id');
    }
}
