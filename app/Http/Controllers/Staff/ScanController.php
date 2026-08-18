<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\AccommodationBlock;
use App\Models\AccommodationBed;
use App\Models\RoomAllocation;
use App\Models\AttendanceSession;
use App\Models\AttendanceRecord;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScanController extends Controller
{
    public function index()
    {
        $activeSessions = AttendanceSession::where('is_active', true)->get();
        $blocks = AccommodationBlock::with(['rooms.beds' => function ($q) {
            $q->where('is_occupied', false);
        }])->get();

        return view('staff.scan', compact('activeSessions', 'blocks'));
    }

    public function lookup(Request $request)
    {
        $token = trim($request->input('token'));

        $registration = Registration::where('qr_token', $token)
            ->orWhere('registration_number', $token)
            ->with(['participant', 'shivir', 'roomAllocation.bed.room.block', 'groupMembers.group'])
            ->first();

        if (!$registration) {
            return response()->json(['success' => false, 'message' => 'अमान्य क्यूआर कोड या पंजीयन संख्या नहीं मिली!'], 444);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $registration->id,
                'reg_no' => $registration->registration_number,
                'name' => $registration->participant->full_name,
                'father_name' => $registration->participant->father_name,
                'age' => $registration->participant->age,
                'city' => $registration->participant->city,
                'district' => $registration->participant->district,
                'mobile' => $registration->participant->mobile,
                'emergency_contact' => $registration->participant->emergency_contact_name . ' (' . $registration->participant->emergency_contact_number . ')',
                'status' => $registration->status,
                'checked_in_at' => $registration->checked_in_at ? $registration->checked_in_at->format('d-m-Y h:i A') : 'नहीं हुआ',
                'room_info' => $registration->roomAllocation 
                    ? ($registration->roomAllocation->bed->room->block->name . ' - कमरा ' . $registration->roomAllocation->bed->room->room_number . ' (' . $registration->roomAllocation->bed->bed_number . ')')
                    : 'आवंटित नहीं है',
                'group_info' => $registration->groupMembers->first()?->group?->name ?? 'समूह आवंटित नहीं',
            ],
        ]);
    }

    public function verify(Request $request, Registration $registration)
    {
        $registration->update([
            'status' => 'checked_in',
            'checked_in_at' => now(),
            'checked_in_by' => auth()->id(),
        ]);

        ActivityLog::create([
            'user_id' => auth()->id(),
            'action' => 'verify_registration',
            'description' => "Verified registration {$registration->registration_number} for {$registration->participant->full_name}",
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['success' => true, 'message' => 'पंजीयन सत्यापन सफल! उपस्थिति दर्ज की गई।']);
    }

    public function allocateRoom(Request $request, Registration $registration)
    {
        $request->validate([
            'bed_id' => 'required|exists:accommodation_beds,id',
        ]);

        return DB::transaction(function () use ($request, $registration) {
            $bed = AccommodationBed::where('id', $request->bed_id)->lockForUpdate()->first();

            if ($bed->is_occupied) {
                return response()->json(['success' => false, 'message' => 'यह बिस्तर पहले से ही किसी अन्य को आवंटित है।'], 422);
            }

            // Remove existing allocation if any
            if ($registration->roomAllocation) {
                $registration->roomAllocation->bed->update(['is_occupied' => false]);
                $registration->roomAllocation->delete();
            }

            $bed->update(['is_occupied' => true]);

            RoomAllocation::create([
                'registration_id' => $registration->id,
                'accommodation_bed_id' => $bed->id,
                'allocated_at' => now(),
                'allocated_by' => auth()->id(),
                'notes' => $request->input('notes', 'स्थान पर क्यूआर स्कैनर से आवंटित'),
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'room_allocate',
                'description' => "Allocated Bed {$bed->bed_number} in Room {$bed->room->room_number} to {$registration->registration_number}",
                'ip_address' => $request->ip(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'कमरा सफलतापूर्वक आवंटित किया गया!',
                'room_info' => $bed->room->block->name . ' - कमरा ' . $bed->room->room_number . ' (' . $bed->bed_number . ')',
            ]);
        });
    }

    public function recordAttendance(Request $request, Registration $registration)
    {
        $request->validate([
            'session_id' => 'required|exists:attendance_sessions,id',
        ]);

        $exists = AttendanceRecord::where('attendance_session_id', $request->session_id)
            ->where('registration_id', $registration->id)
            ->exists();

        if ($exists) {
            return response()->json(['success' => false, 'message' => 'इस सत्र की उपस्थिति पहले से ही दर्ज की जा चुकी है!'], 422);
        }

        AttendanceRecord::create([
            'attendance_session_id' => $request->session_id,
            'registration_id' => $registration->id,
            'scanned_at' => now(),
            'scanned_by' => auth()->id(),
            'device_info' => $request->header('User-Agent'),
        ]);

        return response()->json(['success' => true, 'message' => 'उपस्थिति सफलतापूर्वक दर्ज की गई!']);
    }
}
