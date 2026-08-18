<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'shivir_id',
        'participant_id',
        'registration_number',
        'qr_token',
        'status',
        'rules_accepted',
        'checked_in_at',
        'checked_in_by',
        'notes',
    ];

    protected $casts = [
        'rules_accepted' => 'boolean',
        'checked_in_at' => 'datetime',
    ];

    public function shivir(): BelongsTo
    {
        return $this->belongsTo(Shivir::class);
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(Participant::class);
    }

    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }

    public function roomAllocation(): HasOne
    {
        return $this->hasOne(RoomAllocation::class);
    }

    public function attendanceRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function groupMembers(): HasMany
    {
        return $this->hasMany(GroupMember::class);
    }

    public function certificate(): HasOne
    {
        return $this->hasOne(Certificate::class);
    }
}
