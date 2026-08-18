<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Shivir;
use App\Models\AccommodationBed;
use App\Models\AttendanceRecord;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentShivir = Shivir::where('status', 'registration_open')
            ->orWhere('status', 'ongoing')
            ->latest('id')
            ->first() ?? Shivir::latest('id')->first();

        if (!$currentShivir) {
            return view('admin.dashboard', [
                'currentShivir' => null,
                'stats' => [],
            ]);
        }

        $totalRegistrations = Registration::where('shivir_id', $currentShivir->id)->count();
        $todayRegistrations = Registration::where('shivir_id', $currentShivir->id)
            ->whereDate('created_at', now())
            ->count();
        $checkedInCount = Registration::where('shivir_id', $currentShivir->id)
            ->where('status', 'checked_in')
            ->count();
        $allocatedCount = Registration::where('shivir_id', $currentShivir->id)
            ->has('roomAllocation')
            ->count();

        $totalBeds = AccommodationBed::whereHas('room.block', function ($q) use ($currentShivir) {
            $q->where('shivir_id', $currentShivir->id);
        })->count();

        $occupiedBeds = AccommodationBed::whereHas('room.block', function ($q) use ($currentShivir) {
            $q->where('shivir_id', $currentShivir->id);
        })->where('is_occupied', true)->count();

        $todayAttendance = AttendanceRecord::whereHas('session', function ($q) use ($currentShivir) {
            $q->where('shivir_id', $currentShivir->id)->whereDate('session_date', now()->format('Y-m-d'));
        })->count();

        // City & District breakdown
        $districtBreakdown = DB::table('registrations')
            ->join('participants', 'registrations.participant_id', '=', 'participants.id')
            ->where('registrations.shivir_id', $currentShivir->id)
            ->select('participants.district', DB::raw('count(*) as count'))
            ->groupBy('participants.district')
            ->orderBy('count', 'desc')
            ->limit(6)
            ->get();

        // Recent Registrations
        $recentRegistrations = Registration::where('shivir_id', $currentShivir->id)
            ->with(['participant', 'roomAllocation.bed.room.block'])
            ->latest()
            ->take(8)
            ->get();

        $stats = [
            'total_registrations' => $totalRegistrations,
            'today_registrations' => $todayRegistrations,
            'checked_in_count' => $checkedInCount,
            'allocated_count' => $allocatedCount,
            'total_beds' => $totalBeds,
            'occupied_beds' => $occupiedBeds,
            'today_attendance' => $todayAttendance,
        ];

        return view('admin.dashboard', compact('currentShivir', 'stats', 'districtBreakdown', 'recentRegistrations'));
    }
}
