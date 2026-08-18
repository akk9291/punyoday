@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ showSessModal: false }">

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="font-tiro text-2xl font-bold text-slate-900">उपस्थिति सत्र एवं स्कैनर (Attendance & Session Tracking)</h1>
            <p class="text-xs text-slate-500 mt-1">दैनिक धार्मिक सत्रों की उपस्थिति, प्रेजेंट एवं एब्सेंट आंकड़े।</p>
        </div>

        <button @click="showSessModal = true" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold px-4 py-2 rounded-xl text-sm shadow">
            ➕ नया उपस्थिति सत्र सृजित करें
        </button>
    </div>

    <!-- Attendance Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm text-center">
            <div class="text-xs font-bold text-slate-500 uppercase">कुल पंजीकृत</div>
            <div class="font-tiro text-3xl font-extrabold text-slate-900 mt-1">{{ number_format($totalRegistrations) }}</div>
        </div>
        <div class="bg-emerald-50 p-5 rounded-2xl border border-emerald-200 shadow-sm text-center">
            <div class="text-xs font-bold text-emerald-800 uppercase">सत्र में उपस्थित (Present)</div>
            <div class="font-tiro text-3xl font-extrabold text-emerald-700 mt-1">{{ number_format($presentCount) }}</div>
        </div>
        <div class="bg-rose-50 p-5 rounded-2xl border border-rose-200 shadow-sm text-center">
            <div class="text-xs font-bold text-rose-800 uppercase">अनुपस्थित (Absent)</div>
            <div class="font-tiro text-3xl font-extrabold text-rose-700 mt-1">{{ number_format($absentCount) }}</div>
        </div>
    </div>

    <!-- Sessions List & Attendance Log -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-4">
        <h3 class="font-tiro text-xl font-bold text-slate-900">उपस्थिति सत्र सूची (Attendance Sessions)</h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            @foreach($sessions as $sess)
                <a href="{{ route('admin.attendance.index', ['session_id' => $sess->id]) }}" class="p-4 rounded-xl border transition {{ $selectedSession && $selectedSession->id === $sess->id ? 'bg-amber-100 border-amber-400 font-bold text-maroon-900' : 'bg-slate-50 border-slate-200 text-slate-800 hover:bg-slate-100' }}">
                    <div class="text-sm font-bold">{{ $sess->session_name }}</div>
                    <div class="text-xs text-slate-500 mt-1">दिनांक: {{ $sess->session_date->format('d/m/Y') }} | रिकॉर्ड्स: {{ $sess->records_count }}</div>
                </a>
            @endforeach
        </div>

        @if($selectedSession)
            <div class="pt-6 border-t">
                <h4 class="font-bold text-slate-800 text-lg mb-3">सत्र उपस्थिति स्कैन लॉग: {{ $selectedSession->session_name }}</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs">
                        <thead>
                            <tr class="bg-slate-50 text-slate-500 font-bold border-b">
                                <th class="py-2.5 px-3">Reg ID</th>
                                <th class="py-2.5 px-3">नाम</th>
                                <th class="py-2.5 px-3">स्कैन समय</th>
                                <th class="py-2.5 px-3">स्कैनर स्टाफ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($selectedSession->records as $rec)
                                <tr class="hover:bg-slate-50">
                                    <td class="py-2 px-3 font-mono font-bold text-maroon-900">{{ $rec->registration->registration_number }}</td>
                                    <td class="py-2 px-3 font-bold text-slate-900">{{ $rec->registration->participant->full_name }}</td>
                                    <td class="py-2 px-3 text-slate-600">{{ $rec->scanned_at->format('d-m-Y h:i:s A') }}</td>
                                    <td class="py-2 px-3 font-semibold text-slate-700">{{ $rec->scannedBy?->name ?? 'Scanner App' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Session -->
    <div x-show="showSessModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4">
            <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">नया उपस्थिति सत्र बनाएं</h3>
            <form action="{{ route('admin.attendance.session.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="shivir_id" value="{{ $shivir->id }}">
                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">सत्र का नाम (Session Name) *</label>
                    <input type="text" name="session_name" required placeholder="उदा. प्रातः प्रतिक्रमण एवं पूजन (दिवस 2)" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">सत्र दिनांक (Session Date) *</label>
                    <input type="date" name="session_date" required value="{{ date('Y-m-d') }}" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">सत्र प्रकार (Type) *</label>
                    <select name="type" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                        <option value="morning">प्रातः काल (Morning)</option>
                        <option value="session">प्रवचन / कक्षा (Pravachan)</option>
                        <option value="evening">सायंकाल (Evening)</option>
                        <option value="special">विशेष कार्यक्रम</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 border-t pt-4">
                    <button type="button" @click="showSessModal = false" class="bg-slate-200 font-bold px-4 py-2 rounded-xl text-sm">रद्द करें</button>
                    <button type="submit" class="bg-amber-500 text-maroon-900 font-extrabold px-6 py-2 rounded-xl text-sm shadow">सहेजें</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
