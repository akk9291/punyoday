<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'father_name',
        'mother_name',
        'dob',
        'age',
        'mobile',
        'whatsapp',
        'email',
        'address',
        'city',
        'district',
        'state',
        'pincode',
        'education',
        'occupation',
        'family_info',
        'social_org',
        'social_position',
        'previous_shivir_attended',
        'previous_shivir_count',
        'emergency_contact_name',
        'emergency_contact_number',
        'blood_group',
        'photo_path',
        'id_document_path',
    ];

    protected $casts = [
        'dob' => 'date',
        'previous_shivir_attended' => 'boolean',
    ];

    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }
}
