<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Shivir extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'shivir_number',
        'year',
        'slug',
        'location',
        'venue',
        'start_date',
        'end_date',
        'reg_start_date',
        'reg_end_date',
        'status',
        'max_limit',
        'prefix',
        'contact_info',
        'is_male_only',
        'description',
        'main_image',
        'logo',
        'seo_meta',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'reg_start_date' => 'date',
        'reg_end_date' => 'date',
        'is_male_only' => 'boolean',
        'seo_meta' => 'array',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(ShivirSection::class)->orderBy('sort_order');
    }

    public function activeSections(): HasMany
    {
        return $this->sections()->where('is_active', true);
    }

    public function rules(): HasMany
    {
        return $this->hasMany(ShivirRule::class)->orderBy('sort_order');
    }

    public function faqs(): HasMany
    {
        return $this->hasMany(ShivirFaq::class)->orderBy('sort_order');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(ShivirSchedule::class)->orderBy('day_number')->orderBy('sort_order');
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class)->orderBy('id', 'desc');
    }

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    public function accommodationBlocks(): HasMany
    {
        return $this->hasMany(AccommodationBlock::class);
    }

    public function groups(): HasMany
    {
        return $this->hasMany(Group::class);
    }

    public function attendanceSessions(): HasMany
    {
        return $this->hasMany(AttendanceSession::class);
    }

    public function isOpenForRegistration(): bool
    {
        if ($this->status !== 'registration_open') {
            return false;
        }

        $now = now()->startOfDay();

        if ($this->reg_start_date && $now->lt($this->reg_start_date)) {
            return false;
        }

        if ($this->reg_end_date && $now->gt($this->reg_end_date)) {
            return false;
        }

        return $this->registrations()->count() < $this->max_limit;
    }
}
