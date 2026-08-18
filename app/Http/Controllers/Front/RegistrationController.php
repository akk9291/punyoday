<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Shivir;
use App\Models\Registration;
use App\Services\RegistrationService;
use App\Services\QrCodeService;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as Pdf;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function __construct(
        protected RegistrationService $registrationService,
        protected QrCodeService $qrCodeService
    ) {}

    public function create(string $slug)
    {
        $shivir = Shivir::where('slug', $slug)->firstOrFail();

        if (!$shivir->isOpenForRegistration()) {
            return redirect()->route('shivir.detail', $slug)
                ->with('error', 'इस शिविर के लिए पंजीयन अभी बंद है अथवा अधिकतम सीमा पूर्ण हो चुकी है।');
        }

        $shivir->load('rules');

        return view('public.register', compact('shivir'));
    }

    public function store(Request $request, string $slug)
    {
        $shivir = Shivir::where('slug', $slug)->firstOrFail();

        if (!$shivir->isOpenForRegistration()) {
            return back()->with('error', 'इस शिविर के लिए पंजीयन अभी बंद है।');
        }

        $validated = $request->validate([
            // Step 1
            'full_name' => 'required|string|max:100',
            'father_name' => 'required|string|max:100',
            'mother_name' => 'nullable|string|max:100',
            'dob' => 'required|date|before:today',
            'mobile' => 'required|digits:10',
            'whatsapp' => 'nullable|digits:10',
            'email' => 'nullable|email|max:100',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|digits:6',

            // Step 2
            'education' => 'nullable|string|max:100',
            'occupation' => 'nullable|string|max:100',
            'family_info' => 'nullable|string|max:255',
            'social_org' => 'nullable|string|max:150',
            'social_position' => 'nullable|string|max:100',
            'previous_shivir_attended' => 'nullable|boolean',
            'previous_shivir_count' => 'nullable|integer|min:0',

            // Step 3
            'emergency_contact_name' => 'required|string|max:100',
            'emergency_contact_number' => 'required|digits:10',
            'blood_group' => 'nullable|string|max:10',

            // Step 4
            'photo' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'id_document' => 'nullable|file|mimes:jpeg,jpg,png,pdf|max:4096',

            // Step 5
            'rules_accepted' => 'required|accepted',
        ], [
            'full_name.required' => 'कृपया पूरा नाम दर्ज करें।',
            'father_name.required' => 'कृपया पिता का नाम दर्ज करें।',
            'dob.required' => 'जन्म तिथि अनिवार्य है।',
            'mobile.required' => '10 अंकों का मोबाइल नंबर दर्ज करें।',
            'address.required' => 'पता दर्ज करना अनिवार्य है।',
            'city.required' => 'नगर / शहर दर्ज करें।',
            'district.required' => 'जिला दर्ज करें।',
            'state.required' => 'राज्य का चयन करें।',
            'pincode.required' => '6 अंकों का पिनकोड दर्ज करें।',
            'emergency_contact_name.required' => 'आपातकालीन संपर्क व्यक्ति का नाम अनिवार्य है।',
            'emergency_contact_number.required' => 'आपातकालीन मोबाइल नंबर दर्ज करें।',
            'rules_accepted.accepted' => 'शिविर के नियमों को स्वीकार करना अनिवार्य है।',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        }

        $docPath = null;
        if ($request->hasFile('id_document')) {
            $docPath = $request->file('id_document')->store('documents', 'public');
        }

        $registration = $this->registrationService->createRegistration($shivir, $validated, $photoPath, $docPath);

        return redirect()->route('registration.success', $registration->registration_number)
            ->with('success', 'आपका पंजीयन सफलता पूर्वक दर्ज कर लिया गया है!');
    }

    public function success(string $regNo)
    {
        $registration = Registration::where('registration_number', $regNo)
            ->with(['participant', 'shivir', 'roomAllocation.bed.room.block'])
            ->firstOrFail();

        $qrDataUri = $this->qrCodeService->generateBase64DataUri($registration->qr_token);

        return view('public.success', compact('registration', 'qrDataUri'));
    }

    public function downloadPdf(string $regNo)
    {
        $registration = Registration::where('registration_number', $regNo)
            ->with(['participant', 'shivir', 'roomAllocation.bed.room.block'])
            ->firstOrFail();

        $qrDataUri = $this->qrCodeService->generateBase64DataUri($registration->qr_token, 150);

        $pdf = Pdf::loadView('pdf.registration-slip', compact('registration', 'qrDataUri'));

        return $pdf->download("sanskar-shivir-slip-{$registration->registration_number}.pdf");
    }
}
