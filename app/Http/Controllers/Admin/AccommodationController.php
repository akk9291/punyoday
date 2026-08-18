<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shivir;
use App\Models\AccommodationBlock;
use App\Models\AccommodationRoom;
use App\Models\AccommodationBed;
use App\Models\RoomAllocation;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccommodationController extends Controller
{
    public function index(Request $request)
    {
        $shivirId = $request->get('shivir_id');
        $shivir = $shivirId 
            ? Shivir::findOrFail($shivirId) 
            : (Shivir::where('status', 'registration_open')->latest('id')->first() ?? Shivir::latest('id')->first());

        $shivirs = Shivir::orderBy('year', 'desc')->get();

        $blocks = $shivir->accommodationBlocks()->with(['rooms.beds.allocation.registration.participant'])->get();

        return view('admin.accommodation.index', compact('shivir', 'shivirs', 'blocks'));
    }

    public function storeBlock(Request $request)
    {
        $validated = $request->validate([
            'shivir_id' => 'required|exists:shivirs,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        AccommodationBlock::create($validated);

        return back()->with('success', 'नया आवास ब्लॉक जोड़ा गया!');
    }

    public function storeRoom(Request $request)
    {
        $validated = $request->validate([
            'accommodation_block_id' => 'required|exists:accommodation_blocks,id',
            'room_number' => 'required|string|max:20',
            'capacity' => 'required|integer|min:1|max:50',
            'floor' => 'nullable|string|max:50',
        ]);

        $room = AccommodationRoom::create($validated);

        // Auto create beds according to capacity
        for ($i = 1; $i <= $validated['capacity']; $i++) {
            AccommodationBed::create([
                'accommodation_room_id' => $room->id,
                'bed_number' => "Bed-{$i}",
                'is_occupied' => false,
            ]);
        }

        return back()->with('success', "कमरा नंबर {$room->room_number} तथा {$validated['capacity']} बिस्तर जोड़े गए!");
    }

    public function allocate(Request $request)
    {
        $validated = $request->validate([
            'registration_id' => 'required|exists:registrations,id',
            'accommodation_bed_id' => 'required|exists:accommodation_beds,id',
        ]);

        return DB::transaction(function () use ($validated) {
            $bed = AccommodationBed::findOrFail($validated['accommodation_bed_id']);
            if ($bed->is_occupied) {
                return back()->with('error', 'चयनित बिस्तर पहले से ही भरा हुआ है।');
            }

            $registration = Registration::findOrFail($validated['registration_id']);

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
            ]);

            return back()->with('success', 'कमरा / बिस्तर सफलतापूर्वक आवंटित किया गया!');
        });
    }

    public function deallocate(RoomAllocation $allocation)
    {
        DB::transaction(function () use ($allocation) {
            $allocation->bed->update(['is_occupied' => false]);
            $allocation->delete();
        });

        return back()->with('success', 'बिस्तर खाली किया गया!');
    }
}
