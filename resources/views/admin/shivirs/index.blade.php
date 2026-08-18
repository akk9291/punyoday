@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
        <div>
            <h1 class="font-tiro text-2xl font-bold text-slate-900">बहु-वर्षीय संस्कार शिविर प्रबंधन (Multi-Year Shivir Manager)</h1>
            <p class="text-xs text-slate-500 mt-1">प्रत्येक वर्ष के शिविरों को बनाएं, संपादित करें एवं आर्काइव करें।</p>
        </div>
        <a href="{{ route('admin.shivirs.create') }}" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold px-5 py-2.5 rounded-xl shadow transition text-sm flex items-center gap-1.5">
            ➕ नया वार्षिक शिविर जोड़ें
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold border-b text-xs uppercase tracking-wider">
                        <th class="py-3.5 px-4">वर्ष / संख्या</th>
                        <th class="py-3.5 px-4">शिविर का नाम</th>
                        <th class="py-3.5 px-4">स्थान एवं वेन्यू</th>
                        <th class="py-3.5 px-4">अवधि (Start - End)</th>
                        <th class="py-3.5 px-4">स्थिति (Status)</th>
                        <th class="py-3.5 px-4">अधिकतम सीमा</th>
                        <th class="py-3.5 px-4 text-right">कार्रवाई (Action)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($shivirs as $s)
                        <tr class="hover:bg-slate-50">
                            <td class="py-4 px-4">
                                <span class="font-extrabold text-maroon-900 text-base block">{{ $s->year }}</span>
                                <span class="text-xs text-slate-500 font-semibold">{{ $s->shivir_number }}</span>
                            </td>
                            <td class="py-4 px-4 font-bold text-slate-900">{{ $s->name }}</td>
                            <td class="py-4 px-4 text-xs text-slate-700">
                                <div><strong>{{ $s->location }}</strong></div>
                                <div class="text-slate-500">{{ $s->venue }}</div>
                            </td>
                            <td class="py-4 px-4 text-xs font-medium text-slate-700">
                                {{ $s->start_date->format('d/m/Y') }} - {{ $s->end_date->format('d/m/Y') }}
                            </td>
                            <td class="py-4 px-4">
                                <span class="px-3 py-1 rounded-full text-xs font-bold capitalize 
                                    {{ $s->status === 'registration_open' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : '' }}
                                    {{ $s->status === 'archived' ? 'bg-slate-100 text-slate-600' : '' }}
                                    {{ $s->status === 'draft' ? 'bg-amber-100 text-amber-800' : '' }}">
                                    {{ $s->status }}
                                </span>
                            </td>
                            <td class="py-4 px-4 text-xs font-bold text-slate-800">{{ number_format($s->max_limit) }} प्रतिभागी</td>
                            <td class="py-4 px-4 text-right space-x-2">
                                <a href="{{ route('admin.shivirs.edit', $s->id) }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold px-3 py-1.5 rounded-lg text-xs transition inline-block">
                                    ✏️ एडिट करें
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
