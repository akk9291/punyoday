<?php

namespace App\Services;

use App\Models\Participant;
use App\Models\Registration;
use App\Models\Shivir;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RegistrationService
{
    public function generateRegistrationNumber(Shivir $shivir): string
    {
        $prefix = $shivir->prefix ?? ('SHIVIR-' . $shivir->year . '-');
        
        $lastRegistration = Registration::where('shivir_id', $shivir->id)
            ->latest('id')
            ->first();

        if (!$lastRegistration) {
            $nextSeq = 1;
        } else {
            $lastNum = $lastRegistration->registration_number;
            $parts = explode('-', $lastNum);
            $lastSeq = (int) end($parts);
            $nextSeq = $lastSeq + 1;
        }

        return $prefix . str_pad($nextSeq, 5, '0', STR_PAD_LEFT);
    }

    public function createRegistration(Shivir $shivir, array $data, ?string $photoPath = null, ?string $docPath = null): Registration
    {
        return DB::transaction(function () use ($shivir, $data, $photoPath, $docPath) {
            // Calculate age from DOB if present
            $dob = Carbon::parse($data['dob']);
            $age = $dob->age;

            $participant = Participant::create([
                'full_name' => $data['full_name'],
                'father_name' => $data['father_name'],
                'mother_name' => $data['mother_name'] ?? null,
                'dob' => $dob->format('Y-m-d'),
                'age' => $age,
                'mobile' => $data['mobile'],
                'whatsapp' => $data['whatsapp'] ?? $data['mobile'],
                'email' => $data['email'] ?? null,
                'address' => $data['address'],
                'city' => $data['city'],
                'district' => $data['district'],
                'state' => $data['state'],
                'pincode' => $data['pincode'],
                'education' => $data['education'] ?? null,
                'occupation' => $data['occupation'] ?? null,
                'family_info' => $data['family_info'] ?? null,
                'social_org' => $data['social_org'] ?? null,
                'social_position' => $data['social_position'] ?? null,
                'previous_shivir_attended' => !empty($data['previous_shivir_attended']),
                'previous_shivir_count' => (int)($data['previous_shivir_count'] ?? 0),
                'emergency_contact_name' => $data['emergency_contact_name'],
                'emergency_contact_number' => $data['emergency_contact_number'],
                'blood_group' => $data['blood_group'] ?? null,
                'photo_path' => $photoPath,
                'id_document_path' => $docPath,
            ]);

            $regNum = $this->generateRegistrationNumber($shivir);
            $qrToken = Str::random(40);

            return Registration::create([
                'shivir_id' => $shivir->id,
                'participant_id' => $participant->id,
                'registration_number' => $regNum,
                'qr_token' => $qrToken,
                'status' => 'approved',
                'rules_accepted' => true,
            ]);
        });
    }

    public function findByRegNumberOrMobile(Shivir $shivir, string $query): ?Registration
    {
        $query = trim($query);

        return Registration::where('shivir_id', $shivir->id)
            ->where(function ($q) use ($query) {
                $q->where('registration_number', $query)
                  ->orWhereHas('participant', function ($pq) use ($query) {
                      $pq->where('mobile', $query);
                  });
            })
            ->with(['participant', 'shivir', 'roomAllocation.bed.room.block', 'groupMembers.group'])
            ->first();
    }
}
