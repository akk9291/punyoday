@extends('layouts.app')

@section('content')

<!-- 1. Hero Banner Section with Clear High-Visibility Devotees Background -->
<section class="bg-[#3b0202] text-white py-10 sm:py-14 lg:py-16 relative overflow-hidden border-b-8 border-amber-500 shadow-2xl">
    <!-- Devotees Shivir Background Image Layer (High Visibility & Brightness) -->
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-75 pointer-events-none" style="background-image: url('{{ asset('images/shivir_bg.jpg') }}');"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-[#3b0202]/60 via-[#4a0404]/50 to-[#3b0202]/70 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center space-y-5">
        
        <!-- Occasion Pill Badge -->
        <div>
            <div class="inline-flex items-center gap-2 bg-amber-500/25 border border-amber-400/50 text-amber-200 text-xs sm:text-sm font-semibold px-4 py-1.5 rounded-full shadow-md backdrop-blur-md">
                ✨ दशलक्षण महापर्व एवं चतुर्मास महोत्सव के पावन अवसर पर
            </div>
        </div>

        <!-- Main Headline Title -->
        <h1 class="font-tiro text-2xl sm:text-4xl lg:text-5xl font-bold text-amber-200 tracking-wide drop-shadow-lg leading-normal py-1 max-w-6xl mx-auto">
            {{ $shivir->name }}
        </h1>
        
        <!-- Location & Date Bar -->
        <div class="bg-amber-500/20 border border-amber-400/50 px-6 py-2.5 rounded-2xl max-w-4xl mx-auto text-xs sm:text-sm lg:text-base text-amber-200 font-bold flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-6 shadow-lg backdrop-blur-md">
            <span>📍 स्थान: {{ $shivir->venue }}</span>
            <span class="hidden sm:inline text-amber-400">|</span>
            <span>📅 तिथि: {{ $shivir->start_date->format('d/m/Y') }} से {{ $shivir->end_date->format('d/m/Y') }} (10 दिवसीय)</span>
        </div>

        <div class="w-24 h-0.5 bg-amber-500/60 mx-auto rounded-full my-2"></div>

        <!-- Acharya Vidyasagar Ji Maharaj Blessing Card -->
        <div class="bg-amber-950/90 border-2 border-amber-400/80 p-5 sm:p-7 rounded-3xl max-w-5xl mx-auto space-y-2 shadow-2xl backdrop-blur-md">
            <div class="text-amber-400 font-bold text-xs sm:text-sm tracking-widest uppercase flex items-center justify-center gap-2">
                <span>👑</span> <span>अतिशयकारी आशीर्वाद</span> <span>👑</span>
            </div>
            
            <div class="text-amber-200 font-medium text-xs sm:text-base leading-relaxed italic">
                गणाग्रणी जिनसूर्य
            </div>

            <div class="text-white font-tiro text-2xl sm:text-4xl font-extrabold text-amber-300 leading-tight py-1">
                आचार्यश्रेष्ठ श्री 108 विद्यासागर जी महाराज
            </div>
        </div>

        <!-- Muni Sudhasagar Ji Maharaj Sanidhya Card -->
        <div class="bg-maroon-950/90 border border-amber-500/40 p-6 sm:p-8 rounded-3xl max-w-5xl mx-auto space-y-3 shadow-2xl backdrop-blur-md">
            <div class="text-amber-400 font-bold text-xs sm:text-sm tracking-widest uppercase flex items-center justify-center gap-2">
                <span>🚩</span> <span>पावन सानिध्य</span> <span>🚩</span>
            </div>
            
            <div class="text-amber-200 font-medium text-xs sm:text-base leading-relaxed italic">
                श्रावक संस्कार शिविर के जनक तीर्थचक्रवर्ती जगतपूज्य निर्यापक श्रमण
            </div>

            <div class="text-white font-tiro text-2xl sm:text-4xl font-extrabold text-amber-300 leading-tight py-1">
                मुनिपुंगव श्री 108 सुधासागर जी महाराज
            </div>

            <div class="text-amber-200/90 font-tiro text-base sm:text-xl font-medium pt-1 space-y-1">
                <div>क्षुल्लक श्री गंभीरसागर 'वर्णीजी' महाराज</div>
                <div>क्षुल्लक श्री वरिष्ठसागर जी महाराज</div>
                <div>क्षुल्लक श्री विदेहसागर जी महाराज</div>
            </div>
        </div>

        <!-- Primary Action CTA Buttons -->
        <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-3">
            @if($shivir->isOpenForRegistration())
                <a href="{{ route('registration.create', $shivir->slug) }}" class="w-full sm:w-auto bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold text-base sm:text-lg px-8 py-3.5 rounded-2xl shadow-xl transition transform hover:-translate-y-0.5 border-2 border-amber-300">
                    🚩 ऑनलाइन पंजीयन फॉर्म भरें
                </a>
            @else
                <button disabled class="w-full sm:w-auto bg-slate-600 text-slate-300 font-bold text-base px-8 py-3.5 rounded-2xl cursor-not-allowed">
                    पंजीयन स्थिति: {{ $shivir->status === 'completed' ? 'शिविर पूर्ण हुआ' : 'पंजीयन बंद' }}
                </button>
            @endif

            <a href="{{ route('registration.status') }}" class="w-full sm:w-auto bg-maroon-900 hover:bg-maroon-800 text-amber-200 border-2 border-amber-400/60 font-bold text-base sm:text-lg px-8 py-3.5 rounded-2xl shadow-xl transition">
                🔍 अपना पंजीयन खोजें / पर्ची प्रिंट करें
            </a>
        </div>

    </div>
</section>

<!-- 2. Dynamic Shivir Punyarjak Families Section (Golden Cards) -->
@php
    $punyarjakSection = $shivir->sections->first(function($sec) {
        return str_contains($sec->title, 'पुण्यार्जक');
    });
@endphp

@if($punyarjakSection && $punyarjakSection->activeItems->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
    <div class="max-w-5xl mx-auto space-y-4">
        <div class="grid grid-cols-1 {{ $punyarjakSection->activeItems->count() > 1 ? 'md:grid-cols-2' : '' }} {{ $punyarjakSection->activeItems->count() > 2 ? 'lg:grid-cols-3' : '' }} gap-6">
            @foreach($punyarjakSection->activeItems as $punyarjak)
                <div class="bg-amber-500 text-maroon-950 p-6 sm:p-8 rounded-3xl border-4 border-amber-600 shadow-xl text-center space-y-2 transform hover:-translate-y-1 transition duration-300">
                    <!-- Header Title -->
                    <div class="font-bold text-xs sm:text-sm uppercase tracking-wider text-maroon-900">
                        शिविर पुण्यार्जक
                    </div>

                    <!-- Optional Photo -->
                    @if($punyarjak->photo_path)
                        <div class="my-2">
                            <img src="{{ asset('storage/' . $punyarjak->photo_path) }}" alt="{{ $punyarjak->name }}" class="w-24 h-24 rounded-full mx-auto border-2 border-maroon-900 object-cover shadow-md">
                        </div>
                    @endif

                    <!-- Family Name (Main Title) -->
                    <div class="font-tiro text-2xl sm:text-3xl font-extrabold text-maroon-950 leading-tight">
                        {{ $punyarjak->name }}
                    </div>

                    <!-- Family Members List (Subtext) -->
                    <p class="font-tiro text-xs sm:text-sm font-bold text-maroon-900 leading-relaxed pt-1">
                        {{ $punyarjak->department }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- 3. Welcome Letter / Dharmik Amantran Card Section (100% Dynamic) -->
@php
    $welcomeSection = $shivir->sections->first(function($sec) {
        return str_contains($sec->title, 'धर्मानुरागी') || str_contains($sec->title, 'आमंत्रण') || str_contains($sec->title, 'पत्र');
    });
@endphp

@if($welcomeSection)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10">
    <div class="max-w-5xl mx-auto text-left">
        <div class="bg-white border-2 border-amber-300 p-6 sm:p-10 rounded-3xl shadow-xl text-slate-900 space-y-4 relative overflow-hidden">
            <!-- Decorative Golden Header Accent -->
            <div class="flex items-center gap-2 border-b-2 border-amber-200 pb-3 mb-2">
                <span class="text-2xl">📜</span>
                <h3 class="font-tiro text-2xl sm:text-3xl font-extrabold text-maroon-900 tracking-wide">
                    {{ $welcomeSection->title }}
                </h3>
            </div>

            <div class="font-tiro text-base sm:text-lg text-slate-800 leading-relaxed space-y-4 font-medium">
                {!! nl2br(e($welcomeSection->description)) !!}

                <div class="bg-amber-50 border-l-4 border-amber-600 p-4 rounded-r-2xl text-maroon-900 font-bold text-sm sm:text-base mt-4 shadow-sm flex items-center gap-2 border border-amber-200">
                    <span>🤝</span>
                    <span>ऑनलाइन फॉर्म को भरने में आपको कहीं भी कोई असुविधा हो तो हमसे संपर्क कर सकते हैं।</span>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- 4. Organizers & Committee Directory Section with High-Visibility Devotees Background -->
@php
    $teamSection = $shivir->sections->first(function($sec) {
        return str_contains($sec->title, 'निर्देशक') || str_contains($sec->title, 'प्रबन्ध') || str_contains($sec->title, 'कार्यकारिणी');
    });
@endphp

@if($teamSection && $teamSection->activeItems->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <div class="bg-[#3b0202] text-white rounded-3xl p-6 sm:p-10 border-4 border-amber-500/80 shadow-2xl relative overflow-hidden">
        <!-- Devotees Shivir Background Image Layer (High Visibility) -->
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-70 pointer-events-none" style="background-image: url('{{ asset('images/shivir_bg.jpg') }}');"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#3b0202]/60 via-[#4a0404]/55 to-[#3b0202]/70 pointer-events-none"></div>

        <div class="relative z-10 space-y-8">
            
            <!-- Top Centered Leadership & Directors -->
            @php
                $advisers = $teamSection->activeItems->filter(function($i) {
                    return str_contains($i->designation, 'परामर्शक') || str_contains($i->designation, 'निर्देशक');
                });
                $committeeItems = $teamSection->activeItems->reject(function($i) {
                    return str_contains($i->designation, 'परामर्शक') || str_contains($i->designation, 'निर्देशक');
                });
                $groupedCommittees = $committeeItems->groupBy('designation');
            @endphp

            @if($advisers->count() > 0)
                <div class="text-center space-y-2 border-b border-amber-500/30 pb-6 max-w-4xl mx-auto">
                    @foreach($advisers as $adv)
                        <div class="font-tiro text-amber-300 font-bold text-lg sm:text-2xl leading-relaxed drop-shadow">
                            {{ $adv->designation }} - {{ $adv->name }}
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- 4 Committee Columns (2x2 Grid) -->
            @if($groupedCommittees->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10 max-w-6xl mx-auto text-left">
                    @foreach($groupedCommittees as $category => $members)
                        <div class="space-y-3 bg-maroon-950/85 p-5 sm:p-6 rounded-2xl border border-amber-500/40 backdrop-blur-md shadow-lg">
                            <!-- Category Golden Header -->
                            <h3 class="font-tiro text-amber-400 font-bold text-xl sm:text-2xl border-b border-amber-500/40 pb-2 mb-3">
                                {{ $category }}
                            </h3>

                            <!-- Members List with Mobile Numbers -->
                            <div class="space-y-2">
                                @foreach($members as $m)
                                    <div class="font-tiro text-white text-base sm:text-lg font-medium flex items-center justify-between gap-2 border-b border-amber-500/10 pb-1.5">
                                        <span>{{ $m->name }}</span>
                                        @if($m->mobile)
                                            <span class="font-mono text-amber-200 text-sm sm:text-base font-bold whitespace-nowrap">
                                                - {{ $m->mobile }}
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- 5. Organizers, Nivedak & Vineet Block (Matching Screenshot Exactly) -->
            @php
                $organizerSec = $shivir->sections->first(function($sec) {
                    return str_contains($sec->title, 'आयोजक') || str_contains($sec->title, 'निवेदक') || str_contains($sec->title, 'विनीत');
                });
            @endphp

            @if($organizerSec && $organizerSec->activeItems->count() > 0)
                @php
                    $groupedOrganizers = $organizerSec->activeItems->groupBy('designation');
                @endphp
                
                <div class="pt-8 border-t-2 border-amber-500/40 max-w-5xl mx-auto text-center space-y-6">
                    @foreach($groupedOrganizers as $headerTitle => $orgMembers)
                        <div class="space-y-2">
                            <!-- Golden Header Title -->
                            <div class="font-tiro text-amber-400 font-extrabold text-xl sm:text-3xl leading-snug">
                                {{ $headerTitle }}
                            </div>

                            <!-- Member Name & Phone Numbers -->
                            <div class="space-y-1">
                                @foreach($orgMembers as $om)
                                    @if(str_contains($om->designation, 'विनीत'))
                                        <div class="font-tiro text-amber-300 font-bold text-lg sm:text-2xl pt-2">
                                            {{ $om->name }}
                                        </div>
                                    @else
                                        <div class="font-tiro text-white font-bold text-base sm:text-xl">
                                            {{ $om->name }} @if($om->mobile) <span class="font-mono text-amber-200">- {{ $om->mobile }}</span> @endif
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</section>
@endif

<!-- Dynamic CMS Information Sections -->
@foreach($shivir->sections as $sec)
@if(!str_contains($sec->title, 'पुण्यार्जक') && !str_contains($sec->title, 'निर्देशक') && !str_contains($sec->title, 'प्रबन्ध') && !str_contains($sec->title, 'आयोजक') && !str_contains($sec->title, 'निवेदक') && !str_contains($sec->title, 'विनीत') && !str_contains($sec->title, 'आशीर्वाद') && !str_contains($sec->title, 'सानिध्य'))
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <div class="{{ $sec->background ?? 'bg-white' }} rounded-3xl p-6 sm:p-10 border border-amber-200/80 shadow-md">
        <div class="text-center max-w-3xl mx-auto mb-8">
            <h2 class="font-tiro text-3xl sm:text-4xl font-bold text-maroon-900 mb-2">{{ $sec->title }}</h2>
            @if($sec->subtitle)
                <p class="text-amber-800 font-bold text-base sm:text-lg mb-2">{{ $sec->subtitle }}</p>
            @endif
            @if($sec->description)
                <p class="text-slate-600 text-sm sm:text-base leading-relaxed">{!! nl2br(e($sec->description)) !!}</p>
            @endif
        </div>

        @if($sec->activeItems->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($sec->activeItems as $item)
                    <div class="bg-white rounded-2xl p-6 border border-amber-200/80 shadow-sm hover:shadow-md transition text-center flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full bg-amber-100 border-2 border-amber-400 flex items-center justify-center text-3xl font-bold text-maroon-900 mb-4 shadow-sm">
                            👤
                        </div>
                        <h3 class="font-bold text-slate-900 text-lg mb-1">{{ $item->name }}</h3>
                        @if($item->designation)
                            <div class="text-amber-900 font-bold text-xs mb-2 bg-amber-100 px-3 py-1 rounded-full border border-amber-300">
                                {{ $item->designation }}
                            </div>
                        @endif
                        @if($item->department)
                            <div class="text-xs text-slate-500 mb-2 font-medium">{{ $item->department }}</div>
                        @endif
                        @if($item->description)
                            <p class="text-xs text-slate-600 mb-3 leading-relaxed">{{ $item->description }}</p>
                        @endif
                        @if($item->mobile)
                            <div class="text-xs text-slate-800 font-bold mt-auto pt-3 border-t border-slate-100 w-full">
                                📞 संपर्क: <span class="font-mono text-amber-800">{{ $item->mobile }}</span>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endif
@endforeach

<!-- Daily Schedule Time-Table -->
@if($shivir->schedules->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-amber-200 shadow-md">
        <div class="text-center mb-8">
            <h2 class="font-tiro text-3xl font-bold text-maroon-900">शिविर की दैनिक धर्मचर्या एवं समय-सारिणी</h2>
            <p class="text-slate-600 text-sm mt-1">10 दिवसीय शिविर हेतु प्रातः जागरण से रात्रि सामायिक तक का निर्धारित कार्यक्रम</p>
        </div>

        <div class="divide-y divide-slate-100 border border-slate-200 rounded-2xl overflow-hidden">
            @foreach($shivir->schedules as $sch)
                <div class="p-4 flex flex-col md:flex-row items-start md:items-center justify-between gap-4 hover:bg-amber-50/50 transition">
                    <div class="flex items-center gap-4">
                        <div class="bg-maroon-800 text-amber-300 font-bold text-sm px-4 py-2 rounded-xl whitespace-nowrap shadow-sm border border-amber-500/40">
                            ⏱️ {{ $sch->time_slot }}
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900 text-base sm:text-lg">{{ $sch->activity_name }}</h4>
                            @if($sch->location_venue)
                                <div class="text-xs text-amber-800 font-semibold mt-0.5">📍 स्थान: {{ $sch->location_venue }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Shivir Rules & Terms -->
@if($shivir->rules->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12">
    <div class="bg-amber-900 text-amber-50 rounded-3xl p-6 sm:p-10 border-2 border-amber-500 shadow-2xl">
        <div class="text-center mb-8">
            <h2 class="font-tiro text-3xl sm:text-4xl font-bold text-amber-200">शिविर के आवश्यक नियम एवं दिशा-निर्देश</h2>
            <p class="text-amber-100/80 text-sm mt-1">प्रत्येक शिविरार्थी द्वारा पालन हेतु अनिवार्य निर्देश</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($shivir->rules as $index => $rule)
                <div class="bg-maroon-900/90 p-5 rounded-2xl border border-amber-500/40 space-y-2">
                    <h4 class="font-bold text-amber-300 text-base sm:text-lg flex items-center gap-2">
                        <span>📌</span> <span>{{ $index + 1 }}. {{ $rule->title }}</span>
                    </h4>
                    <p class="text-xs sm:text-sm text-amber-100/90 leading-relaxed">{!! nl2br(e($rule->rule_text)) !!}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Dynamic FAQs Accordion -->
@if($shivir->faqs->count() > 0)
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 mb-16" x-data="{ openFaq: null }">
    <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-md">
        <div class="text-center mb-8">
            <h2 class="font-tiro text-3xl font-bold text-maroon-900">प्रायः पूछे जाने वाले प्रश्न (FAQs)</h2>
            <p class="text-slate-600 text-sm mt-1">शिविर से संबंधित सामान्य जिज्ञासाएं</p>
        </div>

        <div class="space-y-4 max-w-4xl mx-auto">
            @foreach($shivir->faqs as $index => $faq)
                <div class="bg-slate-50 rounded-2xl border border-slate-200 overflow-hidden">
                    <button @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}" class="w-full p-5 text-left font-bold text-slate-900 text-base flex items-center justify-between gap-4 focus:outline-none">
                        <span>❓ {{ $faq->question }}</span>
                        <span class="text-amber-800 font-extrabold text-xl" x-text="openFaq === {{ $index }} ? '−' : '+'"></span>
                    </button>
                    <div x-show="openFaq === {{ $index }}" class="p-5 pt-0 text-sm text-slate-700 border-t border-slate-200 leading-relaxed bg-white">
                        {!! nl2br(e($faq->answer)) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Bottom CTA Banner -->
<section class="bg-maroon-900 text-amber-200 py-12 border-t-4 border-amber-500">
    <div class="max-w-4xl mx-auto px-4 text-center space-y-4">
        <h2 class="font-tiro text-3xl font-bold text-amber-300">क्या आपने अपना ऑनलाइन पंजीयन करवा लिया है?</h2>
        <p class="text-amber-100/90 text-sm sm:text-base">
            पुण्योदय भारत द्वारा संचालित 33वें वार्षिक श्रावक संस्कार शिविर में अपनी उपस्थिति सुनिश्चित करने के लिए अभी अपना ऑनलाइन फॉर्म भरें।
        </p>
        <div class="pt-2">
            <a href="{{ route('registration.create', $shivir->slug) }}" class="inline-block bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold text-lg px-8 py-3.5 rounded-2xl shadow-xl transition">
                🚩 अभी ऑनलाइन पंजीयन करें ➔
            </a>
        </div>
    </div>
</section>

@endsection
