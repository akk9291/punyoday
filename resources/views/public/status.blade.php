@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <!-- Page Header Card -->
    <div class="bg-white rounded-3xl shadow-xl border border-amber-200 p-6 sm:p-10 mb-8 text-center">
        <h1 class="font-tiro text-3xl sm:text-4xl font-bold text-maroon-900 mb-2">पंजीयन स्थिति एवं पर्ची डाउनलोड करें</h1>
        <p class="text-slate-600 text-sm sm:text-base max-w-xl mx-auto">
            अपनी पंजीयन संख्या (उदा. ASH-2026-00001) अथवा 10 अंकों का पंजीकृत मोबाइल नंबर दर्ज कर स्थिति देखें।
        </p>

        <!-- Search Form -->
        <form action="{{ route('registration.status.check') }}" method="POST" class="mt-6 max-w-2xl mx-auto flex flex-col sm:flex-row gap-3">
            @csrf

            <select name="shivir_id" required class="px-4 py-3.5 rounded-xl border border-slate-300 bg-white font-medium text-slate-800 focus:ring-2 focus:ring-amber-500">
                @foreach($shivirs as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>

            <input type="text" name="query" value="{{ old('query') }}" required placeholder="पंजीयन संख्या या मोबाइल नंबर दर्ज करें" class="flex-grow px-5 py-3.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">

            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold px-8 py-3.5 rounded-xl shadow transition text-base whitespace-nowrap">
                🔍 खोजें (Search)
            </button>
        </form>
    </div>

    <!-- Search Result View -->
    @if(isset($registration))
    <div class="bg-white rounded-3xl shadow-2xl border-2 border-amber-400 p-6 sm:p-10 space-y-8">
        
        <div class="flex flex-col sm:flex-row items-center justify-between border-b pb-6 gap-4">
            <div>
                <span class="text-xs font-bold text-amber-700 uppercase tracking-wider block">पंजीयन संख्या</span>
                <h2 class="font-tiro text-3xl font-extrabold text-maroon-900">{{ $registration->registration_number }}</h2>
            </div>
            <div class="text-right">
                <span class="bg-emerald-100 text-emerald-800 font-bold px-4 py-1.5 rounded-full text-sm">
                    स्थिति: {{ $registration->status === 'checked_in' ? 'उपस्थित (Checked In)' : 'स्वीकृत (Approved)' }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- QR Code Card -->
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 text-center flex flex-col items-center justify-center">
                <div class="text-xs font-bold text-slate-600 mb-2">क्यूआर कोड (QR Code)</div>
                <img src="{{ $qrDataUri }}" alt="QR Code" class="w-40 h-40 bg-white p-2 border rounded-xl shadow-sm">
                <div class="text-xs text-slate-500 mt-2">सत्यापन हेतु कोड दिखाएं</div>
            </div>

            <!-- Participant Details -->
            <div class="md:col-span-2 bg-slate-50 p-6 rounded-2xl border border-slate-200 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                <div>
                    <span class="text-slate-500 text-xs block">शिविरार्थी नाम:</span>
                    <strong class="text-slate-900 text-base font-bold">{{ $registration->participant->full_name }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 text-xs block">पिता का नाम:</span>
                    <strong class="text-slate-900 text-base">{{ $registration->participant->father_name }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 text-xs block">आयु:</span>
                    <strong class="text-slate-900">{{ $registration->participant->age }} वर्ष</strong>
                </div>
                <div>
                    <span class="text-slate-500 text-xs block">मोबाइल:</span>
                    <strong class="text-slate-900">{{ $registration->participant->mobile }}</strong>
                </div>
                <div>
                    <span class="text-slate-500 text-xs block">शहर / जिला:</span>
                    <strong class="text-slate-900">{{ $registration->participant->city }} ({{ $registration->participant->district }})</strong>
                </div>
                <div>
                    <span class="text-slate-500 text-xs block">आवंटित कमरा / आवास:</span>
                    @if($registration->roomAllocation)
                        <strong class="text-amber-800 bg-amber-100 px-2 py-1 rounded">
                            {{ $registration->roomAllocation->bed->room->block->name }} - कमरा {{ $registration->roomAllocation->bed->room->room_number }} ({{ $registration->roomAllocation->bed->bed_number }})
                        </strong>
                    @else
                        <span class="text-slate-500 italic">स्थल पर आगमन पर आवंटित होगा</span>
                    @endif
                </div>
                @if($registration->groupMembers->first())
                <div class="sm:col-span-2 pt-2 border-t border-slate-200">
                    <span class="text-slate-500 text-xs block">आवंटित साधना समूह:</span>
                    <strong class="text-maroon-800 font-bold">{{ $registration->groupMembers->first()->group->name }}</strong>
                </div>
                @endif
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4 border-t">
            <a href="{{ route('registration.slip.pdf', $registration->registration_number) }}" class="bg-maroon-800 hover:bg-maroon-900 text-amber-300 font-bold px-8 py-3.5 rounded-xl shadow transition text-base">
                📥 पंजीयन पर्ची PDF डाउनलोड करें
            </a>
            <button onclick="window.print()" class="bg-slate-800 hover:bg-slate-900 text-white font-bold px-6 py-3.5 rounded-xl shadow transition text-base">
                🖨️ प्रिंट करें
            </button>
        </div>

    </div>
    @endif

</div>
@endsection
