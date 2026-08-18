@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <!-- Active Shivir Header Banner -->
    @if($currentShivir)
    <div class="bg-gradient-to-r from-maroon-900 to-maroon-800 text-white rounded-2xl p-6 shadow-md border-b-4 border-amber-500 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <span class="bg-amber-500 text-maroon-900 text-xs font-extrabold px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">
                वर्तमान सक्रिय शिविर
            </span>
            <h1 class="font-tiro text-2xl sm:text-3xl font-bold text-amber-200">{{ $currentShivir->name }}</h1>
            <p class="text-xs sm:text-sm text-amber-100/90 mt-1">
                स्थान: {{ $currentShivir->location }} | अवधि: {{ $currentShivir->start_date->format('d/m/Y') }} से {{ $currentShivir->end_date->format('d/m/Y') }}
            </p>
        </div>
        <div>
            <a href="{{ route('admin.shivirs.edit', $currentShivir->id) }}" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-bold px-4 py-2 rounded-xl text-sm shadow transition">
                ✏️ शिविर सेटिंग्स
            </a>
        </div>
    </div>
    @endif

    <!-- Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">
                <span>कुल पंजीयन (Total Reg)</span>
                <span class="text-lg">📋</span>
            </div>
            <div class="font-tiro text-3xl font-extrabold text-slate-900">{{ number_format($stats['total_registrations'] ?? 0) }}</div>
            <div class="text-xs text-emerald-600 font-semibold mt-1">आज नए आए: +{{ $stats['today_registrations'] ?? 0 }}</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">
                <span>चेक-इन / स्थल पर उपस्थित</span>
                <span class="text-lg">📍</span>
            </div>
            <div class="font-tiro text-3xl font-extrabold text-emerald-700">{{ number_format($stats['checked_in_count'] ?? 0) }}</div>
            <div class="text-xs text-slate-500 font-medium mt-1">वेन्यू सत्यापन संपन्न</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">
                <span>कमरा आवंटित (Allocated)</span>
                <span class="text-lg">🛏️</span>
            </div>
            <div class="font-tiro text-3xl font-extrabold text-amber-700">{{ number_format($stats['allocated_count'] ?? 0) }}</div>
            <div class="text-xs text-slate-500 font-medium mt-1">बिस्तर क्षमता: {{ $stats['occupied_beds'] ?? 0 }} / {{ $stats['total_beds'] ?? 0 }}</div>
        </div>

        <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">
                <span>आज की धर्मचर्या उपस्थिति</span>
                <span class="text-lg">⏱️</span>
            </div>
            <div class="font-tiro text-3xl font-extrabold text-indigo-700">{{ number_format($stats['today_attendance'] ?? 0) }}</div>
            <div class="text-xs text-indigo-600 font-semibold mt-1">स्कैनर द्वारा रिकॉर्ड</div>
        </div>

    </div>

    <!-- Analytics Breakdown & Recent Registrations Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- District Breakdown -->
        <div class="lg:col-span-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <h3 class="font-tiro text-xl font-bold text-slate-900 mb-4 pb-2 border-b">जिला अनुसार पंजीयन (Top Districts)</h3>
            <div class="space-y-3">
                @foreach($districtBreakdown as $db)
                    <div>
                        <div class="flex justify-between text-xs font-bold text-slate-700 mb-1">
                            <span>{{ $db->district }}</span>
                            <span>{{ $db->count }} प्रतिभागी</span>
                        </div>
                        <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                            <div class="bg-amber-500 h-2 rounded-full" style="width: {{ min(100, ($db->count / max(1, $stats['total_registrations'])) * 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Registrations Table -->
        <div class="lg:col-span-8 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4 pb-2 border-b">
                <h3 class="font-tiro text-xl font-bold text-slate-900">नवीनतम पंजीयन तालिका (Recent Registrations)</h3>
                <a href="{{ route('admin.registrations.index') }}" class="text-xs font-bold text-amber-700 hover:underline">
                    सभी देखें ➔
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 font-bold border-b">
                            <th class="py-2.5 px-3">Reg ID</th>
                            <th class="py-2.5 px-3">प्रतिभागी</th>
                            <th class="py-2.5 px-3">नगर / जिला</th>
                            <th class="py-2.5 px-3">स्थिति</th>
                            <th class="py-2.5 px-3">आवास / कमरा</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($recentRegistrations as $reg)
                            <tr class="hover:bg-slate-50">
                                <td class="py-3 px-3 font-mono font-bold text-maroon-900">{{ $reg->registration_number }}</td>
                                <td class="py-3 px-3">
                                    <div class="font-bold text-slate-900">{{ $reg->participant->full_name }}</div>
                                    <div class="text-[11px] text-slate-500">पिता: {{ $reg->participant->father_name }}</div>
                                </td>
                                <td class="py-3 px-3 text-slate-700">{{ $reg->participant->city }} ({{ $reg->participant->district }})</td>
                                <td class="py-3 px-3">
                                    <span class="px-2 py-0.5 rounded-full font-bold text-[10px] {{ $reg->status === 'checked_in' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $reg->status }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 font-semibold text-amber-800">
                                    {{ $reg->roomAllocation ? ($reg->roomAllocation->bed->room->block->name . ' - ' . $reg->roomAllocation->bed->room->room_number) : 'आवंटित नहीं' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>
@endsection
