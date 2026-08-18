@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Venue Kiosk Banner -->
    <div class="bg-maroon-900 text-amber-200 p-8 rounded-3xl shadow-xl text-center border-2 border-amber-500 mb-8">
        <span class="bg-amber-500 text-maroon-900 font-extrabold text-xs px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">
            🖥️ परिसर सहायता कियोस्क (Venue Information Kiosk)
        </span>
        <h1 class="font-tiro text-3xl sm:text-5xl font-bold mb-2">अपना पंजीयन एवं कमरा खोजें</h1>
        <p class="text-amber-100/90 text-sm sm:text-base max-w-xl mx-auto">
            अपनी पंजीयन संख्या (उदा. ASH-2026-00001) दर्ज कर अपना नाम, स्थिति एवं कमरा देखें।
        </p>

        <!-- Kiosk Search Form -->
        <form action="{{ route('kiosk.index') }}" method="GET" class="mt-6 max-w-xl mx-auto flex gap-3">
            <input type="text" name="reg_no" value="{{ request('reg_no') }}" required placeholder="पंजीयन संख्या (Reg ID) दर्ज करें" class="flex-grow px-5 py-4 rounded-2xl text-slate-900 text-lg font-bold shadow focus:ring-4 focus:ring-amber-400">
            <button type="submit" class="bg-amber-500 hover:bg-amber-400 text-maroon-900 font-extrabold text-lg px-8 py-4 rounded-2xl shadow transition">
                🔍 खोजें
            </button>
        </form>
    </div>

    @if(isset($registration))
    <!-- Kiosk Participant Info Card (Public Safe) -->
    <div class="bg-white rounded-3xl shadow-xl border-2 border-amber-400 p-8 text-center space-y-6">
        <div class="inline-block bg-amber-100 border border-amber-300 px-4 py-1.5 rounded-full text-amber-900 font-bold text-sm">
            पंजीयन क्रमांक: {{ $registration->registration_number }}
        </div>

        <h2 class="font-tiro text-4xl font-extrabold text-slate-900">{{ $registration->participant->full_name }}</h2>
        <p class="text-slate-600 text-lg">पिता: {{ $registration->participant->father_name }} | शहर: {{ $registration->participant->city }}</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl mx-auto">
            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200">
                <span class="text-xs text-slate-500 block font-bold mb-1">पंजीयन स्थिति</span>
                <span class="text-lg font-bold text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full">
                    {{ $registration->status === 'checked_in' ? 'चेक-इन पूर्ण' : 'पंजीकृत (Approved)' }}
                </span>
            </div>

            <div class="p-6 bg-amber-50 rounded-2xl border border-amber-200">
                <span class="text-xs text-amber-800 block font-bold mb-1">आवंटित आवास / कमरा</span>
                @if($registration->roomAllocation)
                    <span class="text-lg font-extrabold text-maroon-900">
                        {{ $registration->roomAllocation->bed->room->block->name }} - कमरा {{ $registration->roomAllocation->bed->room->room_number }} ({{ $registration->roomAllocation->bed->bed_number }})
                    </span>
                @else
                    <span class="text-sm font-semibold text-slate-500 italic">काउंटर पर संपर्क कर आवंटन प्राप्त करें</span>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Venue Schedule Cards -->
    <div class="mt-8 bg-white rounded-3xl shadow-md border border-slate-200 p-6 sm:p-8">
        <h3 class="font-tiro text-2xl font-bold text-maroon-900 mb-4 text-center">आज की मुख्य धर्मचर्या</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            @foreach($schedules as $sch)
                <div class="p-4 bg-amber-50/70 rounded-xl border border-amber-200 flex items-center justify-between">
                    <div>
                        <span class="text-xs font-bold text-amber-800 block">⏱️ {{ $sch->time_slot }}</span>
                        <strong class="text-slate-800 text-base font-bold">{{ $sch->activity_name }}</strong>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection
