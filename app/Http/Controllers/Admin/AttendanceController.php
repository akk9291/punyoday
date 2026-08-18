<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shivir;
use App\Models\AttendanceSession;
use App\Models\AttendanceRecord;
use App\Models\Registration;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $shivirId = $request->get('shivir_id');
        $shivir = $shivirId 
            ? Shivir::findOrFail($shivirId) 
            : (Shivir::where('status', 'registration_open')->latest('id')->first() ?? Shivir::latest('id')->first());

        $shivirs = Shivir::orderBy('year', 'desc')->get();

        $sessions = $shivir->attendanceSessions()->withCount('records')->orderBy('session_date', 'desc')->get();

        $selectedSessionId = $request->get('session_id') ?? $sessions->first()?->id;
        $selectedSession = $selectedSessionId ? AttendanceSession::with(['records.registration.participant', 'records.scannedBy'])->find($selectedSessionId) : null;

        $totalRegistrations = Registration::where('shivir_id', $shivir->id)->count();
        $presentCount = $selectedSession ? $selectedSession->records_count : 0;
        $absentCount = max(0, $totalRegistrations - $presentCount);

        return view('admin.attendance.index', compact('shivir', 'shivirs', 'sessions', 'selectedSession', 'totalRegistrations', 'presentCount', 'absentCount'));
    }

    public function storeSession(Request $request)
    {
        $validated = $request->validate([
            'shivir_id' => 'required|exists:shivirs,id',
            'session_name' => 'required|string|max:100',
            'session_date' => 'required|date',
            'type' => 'required|in:morning,evening,session,special,full_day',
        ]);

        AttendanceSession::create($validated);

        return back()->with('success', 'नया उपस्थिति सत्र सफलतापूर्वक सृजित किया गया!');
    }
}
