<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return in_array($this->role, ['super_admin', 'admin']);
    }

    public function canManageRegistrations(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'registration_manager']);
    }

    public function canManageAccommodation(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'accommodation_manager']);
    }

    public function canManageAttendance(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'attendance_manager', 'volunteer']);
    }

    public function canManageContent(): bool
    {
        return in_array($this->role, ['super_admin', 'admin', 'content_manager']);
    }
}
