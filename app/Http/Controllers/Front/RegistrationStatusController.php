<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Shivir;
use App\Services\QrCodeService;
use Illuminate\Http\Request;

class RegistrationStatusController extends Controller
{
    public function __construct(protected QrCodeService $qrCodeService) {}

    public function index()
    {
        $shivirs = Shivir::orderBy('year', 'desc')->get();
        return view('public.status', compact('shivirs'));
    }

    public function check(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:50',
            'shivir_id' => 'required|exists:shivirs,id',
        ], [
            'query.required' => 'कृपया अपना पंजीयन क्रमांक या 10 अंकों का मोबाइल नंबर दर्ज करें।',
        ]);

        $input = trim($request->input('query'));
        $shivirId = $request->input('shivir_id');

        $registration = Registration::where('shivir_id', $shivirId)
            ->where(function ($q) use ($input) {
                $q->where('registration_number', $input)
                  ->orWhereHas('participant', function ($pq) use ($input) {
                      $pq->where('mobile', $input);
                  });
            })
            ->with(['participant', 'shivir', 'roomAllocation.bed.room.block', 'groupMembers.group'])
            ->first();

        if (!$registration) {
            return back()->withInput()->with('error', 'प्रविष्ट पंजीयन क्रमांक अथवा मोबाइल नंबर से कोई पंजीयन रिकॉर्ड नहीं मिला।');
        }

        $qrDataUri = $this->qrCodeService->generateBase64DataUri($registration->qr_token);

        $shivirs = Shivir::orderBy('year', 'desc')->get();
        return view('public.status', compact('registration', 'qrDataUri', 'shivirs'));
    }
}
