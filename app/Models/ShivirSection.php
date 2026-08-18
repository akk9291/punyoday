<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ShivirSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'shivir_id',
        'title',
        'subtitle',
        'description',
        'image',
        'icon',
        'background',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function shivir(): BelongsTo
    {
        return $this->belongsTo(Shivir::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(ShivirSectionItem::class)->orderBy('sort_order');
    }

    public function activeItems(): HasMany
    {
        return $this->items()->where('is_active', true);
    }
}
