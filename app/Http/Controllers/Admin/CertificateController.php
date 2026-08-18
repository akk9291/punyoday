<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shivir;
use App\Models\Registration;
use App\Models\Certificate;
use App\Services\QrCodeService;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function __construct(protected QrCodeService $qrCodeService) {}

    public function index(Request $request)
    {
        $shivirId = $request->get('shivir_id');
        $shivir = $shivirId 
            ? Shivir::findOrFail($shivirId) 
            : Shivir::latest('id')->first();

        $shivirs = Shivir::orderBy('year', 'desc')->get();

        $certificates = Certificate::whereHas('registration', function ($q) use ($shivir) {
            $q->where('shivir_id', $shivir->id);
        })->with('registration.participant')->paginate(20);

        return view('admin.certificates.index', compact('shivir', 'shivirs', 'certificates'));
    }

    public function generateBulk(Request $request, Shivir $shivir)
    {
        $registrations = Registration::where('shivir_id', $shivir->id)
            ->whereIn('status', ['checked_in', 'approved'])
            ->doesntHave('certificate')
            ->get();

        $count = 0;
        foreach ($registrations as $reg) {
            $certNo = 'CERT-' . $shivir->year . '-' . str_pad($reg->id, 5, '0', STR_PAD_LEFT);
            Certificate::create([
                'registration_id' => $reg->id,
                'certificate_number' => $certNo,
                'verification_token' => Str::random(32),
                'issued_date' => now(),
            ]);
            $count++;
        }

        return back()->with('success', "कुल {$count} प्रमाण पत्र सफलतापूर्वक तैयार (Generate) किए गए!");
    }

    public function downloadPdf(Certificate $certificate)
    {
        $certificate->load('registration.participant', 'registration.shivir');
        $qrDataUri = $this->qrCodeService->generateBase64DataUri($certificate->verification_token, 140);

        $pdf = Pdf::loadView('pdf.certificate', compact('certificate', 'qrDataUri'));

        return $pdf->download("certificate-{$certificate->certificate_number}.pdf");
    }
}
