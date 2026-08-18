<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shivir;
use App\Models\Registration;
use App\Models\RoomAllocation;
use App\Models\AttendanceRecord;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function exportRegistrations(Request $request, Shivir $shivir)
    {
        $registrations = Registration::where('shivir_id', $shivir->id)
            ->with(['participant', 'roomAllocation.bed.room.block', 'groupMembers.group'])
            ->get();

        $filename = "sanskar-shivir-registrations-{$shivir->year}.csv";

        $headers = [
            "Content-type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename={$filename}",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($registrations) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel Hindi character support
            fputs($file, "\xEF\xBB\xBF");

            fputcsv($file, [
                'Reg Number', 'Full Name', 'Father Name', 'Age', 'Mobile', 
                'Address', 'City', 'District', 'State', 'Status', 
                'Room Block', 'Room No', 'Bed No', 'Group Name', 'Reg Date'
            ]);

            foreach ($registrations as $reg) {
                $p = $reg->participant;
                $room = $reg->roomAllocation ? ($reg->roomAllocation->bed->room->block->name . ' / Room ' . $reg->roomAllocation->bed->room->room_number . ' / ' . $reg->roomAllocation->bed->bed_number) : 'Not Allocated';
                $group = $reg->groupMembers->first()?->group?->name ?? 'No Group';

                fputcsv($file, [
                    $reg->registration_number,
                    $p->full_name,
                    $p->father_name,
                    $p->age,
                    $p->mobile,
                    $p->address,
                    $p->city,
                    $p->district,
                    $p->state,
                    $reg->status,
                    $reg->roomAllocation?->bed->room->block->name ?? 'N/A',
                    $reg->roomAllocation?->bed->room->room_number ?? 'N/A',
                    $reg->roomAllocation?->bed->bed_number ?? 'N/A',
                    $group,
                    $reg->created_at->format('Y-m-d H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
