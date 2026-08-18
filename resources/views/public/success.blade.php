@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="bg-white rounded-3xl shadow-2xl border-2 border-amber-400 overflow-hidden text-center">
        
        <!-- Header Banner -->
        <div class="bg-emerald-700 text-white p-8">
            <div class="w-16 h-16 bg-white text-emerald-700 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-3 shadow">
                ✓
            </div>
            <h1 class="font-tiro text-3xl sm:text-4xl font-bold text-amber-200 mb-1">जय जिनेन्द्र! पंजीयन सफल हुआ</h1>
            <p class="text-emerald-100 text-sm sm:text-base">आपका पंजीयन सफलतापूर्वक रिकॉर्ड कर लिया गया है।</p>
        </div>

        <!-- Registration Slip Details Body -->
        <div class="p-6 sm:p-10 space-y-6">
            
            <!-- Registration Number Badge -->
            <div class="bg-amber-50 border-2 border-amber-400/80 rounded-2xl p-6 inline-block w-full max-w-md shadow-sm">
                <div class="text-xs font-bold text-amber-800 uppercase tracking-wider mb-1">आपकी पंजीयन संख्या (Registration ID)</div>
                <div class="font-tiro text-3xl sm:text-4xl font-extrabold text-maroon-900 tracking-wider">
                    {{ $registration->registration_number }}
                </div>
                <div class="mt-2 inline-block bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-1 rounded-full">
                    स्थिति: {{ $registration->status === 'approved' ? 'स्वीकृत (Approved)' : 'जांच प्रक्रिया में' }}
                </div>
            </div>

            <!-- QR Code Display -->
            <div class="flex flex-col items-center justify-center p-4 bg-slate-50 rounded-2xl border border-slate-200 max-w-sm mx-auto shadow-inner">
                <div class="mb-2 text-xs font-bold text-slate-600">सुरक्षित डिजिटल क्यूआर कोड (QR Code)</div>
                <div class="p-3 bg-white border border-slate-300 rounded-xl shadow-sm">
                    <img src="{{ $qrDataUri }}" alt="QR Code" class="w-44 h-44">
                </div>
                <div class="text-xs text-slate-500 mt-2">शिविर स्थल पर सत्यापन एवं कमरा आवंटन हेतु इसे दिखाएं</div>
            </div>

            <!-- Participant Information Summary -->
            <div class="bg-slate-50 rounded-2xl p-6 text-left border border-slate-200 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-slate-500 block text-xs">शिविरार्थी का नाम:</span>
                    <strong class="text-slate-900 text-base font-bold">{{ $registration->participant->full_name }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block text-xs">पिता का नाम:</span>
                    <strong class="text-slate-900 text-base">{{ $registration->participant->father_name }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block text-xs">मोबाइल नंबर:</span>
                    <strong class="text-slate-900">{{ $registration->participant->mobile }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 block text-xs">शहर एवं राज्य:</span>
                    <strong class="text-slate-900">{{ $registration->participant->city }} ({{ $registration->participant->state }})</strong>
                </div>
                <div class="sm:col-span-2 pt-2 border-t border-slate-200">
                    <span class="text-slate-500 block text-xs">शिविर का नाम:</span>
                    <strong class="text-maroon-900 text-base">{{ $registration->shivir->name }}</strong>
                </div>
            </div>

            <!-- Room Allocation Note -->
            <div class="bg-amber-100/70 border border-amber-300 rounded-xl p-4 text-xs sm:text-sm text-amber-900 font-medium">
                🏢 <strong>आवास एवं कमरा आवंटन:</strong> ऑनलाइन केवल पंजीयन होता है। जब आप शिविर स्थल अशोकनगर पहुंचेंगे, तब प्रवेश काउंटर पर इस क्यूआर कोड को दिखाकर कमरा आवंटित कराया जाएगा।
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4 border-t border-slate-200">
                <a href="{{ route('registration.slip.pdf', $registration->registration_number) }}" class="w-full sm:w-auto bg-maroon-800 hover:bg-maroon-900 text-amber-300 font-bold px-6 py-3.5 rounded-xl shadow-lg transition flex items-center justify-center gap-2 text-base">
                    📥 पंजीयन पर्ची PDF डाउनलोड करें
                </a>

                <button onclick="window.print()" class="w-full sm:w-auto bg-slate-800 hover:bg-slate-900 text-white font-bold px-6 py-3.5 rounded-xl shadow transition flex items-center justify-center gap-2 text-base">
                    🖨️ पर्ची प्रिंट करें
                </button>

                <a href="{{ route('home') }}" class="w-full sm:w-auto bg-slate-200 hover:bg-slate-300 text-slate-800 font-semibold px-6 py-3.5 rounded-xl transition text-base">
                    मुख्य पृष्ठ पर जाएं
                </a>
            </div>

        </div>

    </div>

</div>
@endsection
