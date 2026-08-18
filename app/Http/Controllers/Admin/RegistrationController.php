<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Shivir;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $shivirId = $request->get('shivir_id');
        $shivir = $shivirId 
            ? Shivir::findOrFail($shivirId) 
            : (Shivir::where('status', 'registration_open')->latest('id')->first() ?? Shivir::latest('id')->first());

        $shivirs = Shivir::orderBy('year', 'desc')->get();

        $query = Registration::where('shivir_id', $shivir->id)
            ->with(['participant', 'roomAllocation.bed.room.block', 'groupMembers.group']);

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                  ->orWhereHas('participant', function ($pq) use ($search) {
                      $pq->where('full_name', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%")
                        ->orWhere('city', 'like', "%{$search}%")
                        ->orWhere('district', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('room_status')) {
            if ($request->room_status === 'allocated') {
                $query->has('roomAllocation');
            } elseif ($request->room_status === 'unallocated') {
                $query->doesntHave('roomAllocation');
            }
        }

        $registrations = $query->latest('id')->paginate(15)->withQueryString();

        return view('admin.registrations.index', compact('shivir', 'shivirs', 'registrations'));
    }

    public function show(Registration $registration)
    {
        $registration->load(['participant', 'shivir', 'roomAllocation.bed.room.block', 'groupMembers.group', 'attendanceRecords.session']);
        return view('admin.registrations.show', compact('registration'));
    }

    public function updateStatus(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,checked_in,cancelled',
        ]);

        $registration->update($validated);

        return back()->with('success', 'पंजीयन स्थिति अद्यतन की गई।');
    }
}
