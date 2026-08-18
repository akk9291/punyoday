@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

    <div class="text-center max-w-3xl mx-auto mb-10">
        <h1 class="font-tiro text-4xl font-bold text-maroon-900 mb-2">वार्षिक संस्कार शिविर आर्काइव (Past Shivirs)</h1>
        <p class="text-slate-600 text-base">
            विगत वर्षों में आयोजित समस्त श्रावक संस्कार शिविरों की संपूर्ण जानकारी एवं संस्मरण।
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach($shivirs as $s)
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-amber-200 shadow-md hover:shadow-xl transition flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <span class="bg-amber-100 text-amber-900 font-extrabold px-4 py-1.5 rounded-full text-sm">
                            वर्ष {{ $s->year }}
                        </span>
                        <span class="text-xs font-bold px-3 py-1 rounded-md {{ $s->status === 'registration_open' ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                            {{ $s->status === 'registration_open' ? 'वर्तमान शिविर' : 'आर्काइव्ड (संपन्न)' }}
                        </span>
                    </div>

                    <h3 class="font-tiro text-2xl font-bold text-slate-900 mb-2">{{ $s->name }}</h3>
                    <p class="text-amber-800 font-semibold text-sm mb-4">📍 स्थान: {{ $s->location }} | वेन्यू: {{ $s->venue }}</p>
                    <p class="text-slate-600 text-sm leading-relaxed mb-6">{{ $s->description }}</p>
                </div>

                <div class="pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-500 font-medium">अवधि: {{ $s->start_date->format('d/m/Y') }} से {{ $s->end_date->format('d/m/Y') }}</span>
                    <a href="{{ route('shivir.detail', $s->slug) }}" class="bg-maroon-800 hover:bg-maroon-900 text-amber-300 font-bold px-5 py-2 rounded-xl text-sm transition">
                        शिविर विवरण देखें ➔
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
