<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Shivir;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    public function index(Request $request)
    {
        $shivir = Shivir::where('status', 'registration_open')
            ->orWhere('status', 'ongoing')
            ->latest('id')
            ->first() ?? Shivir::latest('id')->first();

        $registration = null;

        if ($request->filled('reg_no')) {
            $regNo = trim($request->input('reg_no'));
            $registration = Registration::where('shivir_id', $shivir->id)
                ->where('registration_number', $regNo)
                ->with(['participant', 'roomAllocation.bed.room.block', 'groupMembers.group'])
                ->first();
        }

        $schedules = $shivir ? $shivir->schedules()->where('is_active', true)->take(6)->get() : collect();

        return view('public.kiosk', compact('shivir', 'registration', 'schedules'));
    }
}
