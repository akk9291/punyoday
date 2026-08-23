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
                पर्वाधिराज दसलक्षण महापर्व के पावन प्रसंग, गुरुकुल परंपरा पर आधारित
            </div>
        </div>

        <!-- Main Headline Title -->
        <h1 class="font-tiro text-2xl sm:text-4xl lg:text-5xl font-bold text-amber-200 tracking-wide drop-shadow-lg leading-normal py-1 max-w-6xl mx-auto">
            {{ $shivir->name }}
        </h1>
        
        <!-- Location & Date Bar (Styled Box Container & Golden Border, 2 Rows) -->
        <div class="bg-maroon-950/80 border-2 border-amber-400/60 px-6 py-3.5 rounded-2xl max-w-4xl mx-auto text-sm sm:text-base lg:text-lg text-amber-200 font-extrabold space-y-1.5 text-center shadow-xl backdrop-blur-md">
            <div>📍 स्थान - {{ $shivir->venue }}</div>
            <div>📅 दिनांक - 16 सितम्बर 2026 बुधवार से 25 सितम्बर 2026 शुक्रवार तक</div>
        </div>

        <div class="w-24 h-0.5 bg-amber-500/60 mx-auto rounded-full my-2"></div>

        <!-- Acharya Vidyasagar Ji Maharaj Blessing Card -->
        <!-- Acharya Vidyasagar Ji Maharaj Blessing Block (Plain Layout) -->
        <div class="max-w-5xl mx-auto space-y-1 py-2">
            <div class="mb-2">
                <img src="{{ asset('images/acharya_vidyasagar_ji.png') }}" alt="आचार्यश्रेष्ठ श्री १०८ विद्यासागर जी महाराज" class="w-[280px] h-[280px] sm:w-[350px] sm:h-[350px] md:w-[400px] md:h-[400px] mx-auto object-contain drop-shadow-2xl">
            </div>

            <div class="text-amber-400 font-extrabold text-base sm:text-lg md:text-xl flex items-center justify-center gap-2">
                <span>👑</span> <span>अतिशयकारी आशीर्वाद</span> <span>👑</span>
            </div>
            
            <div class="text-amber-200 font-semibold text-sm sm:text-lg md:text-xl lg:text-2xl leading-relaxed">
                गणाग्रणी, जिनसुर्य, आत्मविद्या के पथ प्रदर्शक, मूकमाटी महाकाव्य रचियता, संत शिरोमणि
            </div>

            <div class="text-white font-tiro text-2xl sm:text-4xl font-extrabold text-amber-300 leading-tight drop-shadow-md">
                आचार्यश्रेष्ठ श्री १०८ विद्यासागर जी महाराज
            </div>
        </div>

        <div class="w-32 h-0.5 bg-amber-500/40 mx-auto rounded-full my-2"></div>

        <!-- Muni Sudhasagar Ji Maharaj Sanidhya Block (Plain Layout) -->
        <div class="max-w-5xl mx-auto space-y-2 py-2">
            <div class="text-amber-400 font-extrabold text-base sm:text-lg md:text-xl flex items-center justify-center gap-2">
                <span>✨</span> <span>पावन सानिध्य</span> <span>✨</span>
            </div>
            
            <div class="text-amber-200 font-semibold text-sm sm:text-lg md:text-xl lg:text-2xl leading-relaxed">
                श्रावक संस्कार शिविर के जनक, शांतिधारा महिमा प्रदर्शक, राष्ट्रसंत, श्रमण शिरोमणि, तीर्थचक्रवर्ती, जगतपूज्य
            </div>

            <div class="text-white font-tiro text-2xl sm:text-4xl font-extrabold text-amber-300 leading-tight drop-shadow-md">
                निर्यापक श्रमण मुनिपुंगव श्री १०८ सुधासागर जी महाराज ससंघ
            </div>

            <div class="pt-3">
                <img src="{{ asset('images/muni_sudhasagar_ji.png') }}" alt="निर्यापक श्रमण मुनिपुंगव श्री १०८ सुधासागर जी महाराज" class="w-[280px] h-[280px] sm:w-[350px] sm:h-[350px] md:w-[400px] md:h-[400px] mx-auto object-contain drop-shadow-2xl">
            </div>
        </div>



        <!-- Sangh Sadhu Maharaj Vrind (17 Maharaj Ji Unified List & Mobile Auto-Slider) -->
        @php
            $allMaharajs = [
                'क्षुल्लक रत्न श्री १०५ गंभीरसागर \'वर्णीजी\' महाराज',
                'ऐलक श्री १०५ सुधारसागर जी महाराज',
                'ऐलक श्री १०५ वरिष्ठ सागर जी महाराज',
                'ऐलक श्री १०५ विदेहसागर जी महाराज',
                'ऐलक श्री १०५ सुज्ञानसागर जी महाराज',
                'ऐलक श्री १०५ सुयोगसागर जी महाराज',
                'ऐलक श्री १०५ सुमेध सागर जी महाराज',
                'ऐलक श्री १०५ सुबोध सागर जी महाराज',
                'ऐलक श्री १०५ सुनय सागर जी महाराज',
                'ऐलक श्री १०५ सुधर्म सागर जी महाराज',
                'ऐलक श्री १०५ सुयश सागर जी महाराज',
                'ऐलक श्री १०५ सुदयासागर जी महाराज',
                'ऐलक श्री १०५ सुगुणसागर जी महाराज',
                'ऐलक श्री १०५ सुविवेकसागर जी महाराज',
                'ऐलक श्री १०५ सुशांतसागर जी महाराज',
                'ऐलक श्री १०५ सुचेतन सागर जी महाराज',
                'ऐलक श्री १०५ सुधीरसागर जी महाराज',
            ];
        @endphp

        <div class="-mt-12 sm:-mt-16 md:-mt-20 relative z-20 max-w-7xl mx-auto space-y-3"
             x-data="{
                activeIdx: 0,
                total: {{ count($allMaharajs) }},
                timer: null,
                startAutoScroll() {
                    this.timer = setInterval(() => {
                        if (window.innerWidth < 640) {
                            this.activeIdx = (this.activeIdx + 1) % this.total;
                            const container = $refs.sliderContainer;
                            if (container) {
                                const cardWidth = 190;
                                container.scrollTo({
                                    left: this.activeIdx * cardWidth,
                                    behavior: 'smooth'
                                });
                            }
                        }
                    }, 3000);
                },
                stopAutoScroll() {
                    if (this.timer) clearInterval(this.timer);
                }
             }"
             x-init="startAutoScroll()"
             @mouseenter="stopAutoScroll()"
             @mouseleave="startAutoScroll()"
             @touchstart="stopAutoScroll()"
             @touchend="startAutoScroll()">

            <div class="text-amber-400 font-extrabold text-lg sm:text-xl md:text-2xl flex items-center justify-center gap-2">
                <span>✨</span> <span>पूज्य संघ साधु वृंद</span> <span>✨</span>
            </div>

            <!-- Mobile Touch & Auto-Scrolling Slider / Desktop 6-Column Grid Container -->
            <div x-ref="sliderContainer" class="flex sm:grid sm:grid-cols-3 lg:grid-cols-6 gap-3 overflow-x-auto snap-x snap-mandatory pb-4 sm:pb-0 scroll-smooth">
                @foreach($allMaharajs as $index => $maharajName)
                    <div class="min-w-[170px] sm:min-w-0 snap-center flex-shrink-0 bg-maroon-950/85 p-3.5 sm:p-4 rounded-2xl border border-amber-500/40 text-center space-y-2 shadow-lg backdrop-blur-sm transform hover:-translate-y-1 transition duration-300 flex flex-col items-center justify-between">
                        <!-- Photo Frame Placeholder -->
                        <div class="my-1">
                            <div class="w-16 h-16 sm:w-18 sm:h-18 rounded-full bg-amber-500/10 border-2 border-amber-400/60 mx-auto flex items-center justify-center text-3xl text-amber-300 shadow-inner">
                                👤
                            </div>
                        </div>

                        <!-- Maharaj Ji Name (Non-Bold) -->
                        <div class="font-tiro text-amber-200 font-medium text-xs sm:text-sm leading-snug">
                            {{ $maharajName }}
                        </div>
                    </div>
                @endforeach
            </div>
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
    <div class="max-w-5xl mx-auto">
        <!-- Single Unified Grand Container Box -->
        <div class="bg-amber-500 text-maroon-950 p-6 sm:p-8 rounded-3xl border-4 border-amber-600 shadow-2xl space-y-6">
            
            <!-- Inner Grid of Punyarjak Families -->
            <div class="grid grid-cols-1 {{ $punyarjakSection->activeItems->count() > 1 ? 'md:grid-cols-2' : '' }} gap-8">
                @foreach($punyarjakSection->activeItems as $punyarjak)
                    <div class="bg-amber-400/40 p-6 sm:p-8 rounded-2xl text-center space-y-4 flex flex-col justify-between">
                        
                        <!-- Header Title Badge (शिविर पुण्यार्जक / शिविर मुख्य संयोजक) -->
                        <div class="font-tiro text-xl sm:text-2xl md:text-3xl font-extrabold tracking-wide text-maroon-950 bg-amber-300 py-2 px-6 rounded-full inline-block mx-auto shadow-md">
                            {{ str_replace('🚩 ', '', $punyarjak->designation ?? 'शिविर पुण्यार्जक') }}
                        </div>

                        <!-- Family Photo (Rectangular Landscape Frame) -->
                        @if($punyarjak->photo || $punyarjak->photo_path)
                            <div class="my-2 w-full">
                                <img src="{{ asset('storage/' . ($punyarjak->photo ?? $punyarjak->photo_path)) }}" alt="{{ $punyarjak->name }}" class="w-full max-w-md h-56 sm:h-64 rounded-2xl mx-auto border-4 border-maroon-900 object-cover shadow-xl">
                            </div>
                        @endif

                        <!-- Family Name & Relation (100% Identical Font, Size, Weight & Color) -->
                        <div class="font-tiro text-lg sm:text-xl lg:text-2xl font-extrabold text-maroon-950 leading-snug space-y-1">
                            <div>{{ $punyarjak->name }}</div>
                            @if($punyarjak->department)
                                <div>{{ $punyarjak->department }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Sub-Banner Footer Text ("समस्त कोयला परिवार, भारत...") INSIDE THE SAME SINGLE BOX -->
            @if($punyarjakSection->description)
                <div class="bg-maroon-900 text-amber-200 border-2 border-amber-400 p-6 rounded-2xl text-center space-y-2 shadow-lg">
                    <div class="font-tiro font-extrabold text-2xl sm:text-3xl lg:text-4xl text-amber-300 tracking-wide">
                        {{ strtok($punyarjakSection->description, '(') }}
                    </div>
                    @if(str_contains($punyarjakSection->description, '('))
                        <div class="font-tiro text-base sm:text-lg lg:text-xl font-bold text-amber-100/95 tracking-wide">
                            {{ trim(strstr($punyarjakSection->description, '('), '()') }}
                        </div>
                    @endif
                </div>
            @endif

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
            
            <!-- Top Centered Leadership & Directors (Advisers Cards) -->
            @php
                $advisers = $teamSection->activeItems->filter(function($i) {
                    return str_contains($i->designation, 'परामर्शक') || str_contains($i->designation, 'निर्देशक');
                });
            @endphp

            @if($advisers->count() > 0)
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        @foreach($advisers as $adv)
                            <div class="bg-maroon-950/85 p-5 rounded-2xl border-2 border-amber-500/50 text-center shadow-xl backdrop-blur-md transform hover:-translate-y-1 transition duration-300 flex flex-col items-center justify-start h-full">
                                <!-- Top Designation Title Pill (Fixed Height Container) -->
                                <div class="h-8 flex items-center justify-center">
                                    <div class="inline-block bg-amber-500/20 text-amber-300 border border-amber-400/50 text-xs sm:text-sm font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                                        {{ $adv->designation }}
                                    </div>
                                </div>

                                <!-- Photo Frame in Center (Aligned in 1 straight horizontal line) -->
                                <div class="my-4">
                                    @if(!empty($adv->photo) || !empty($adv->photo_path))
                                        <img src="{{ asset('storage/' . ($adv->photo ?? $adv->photo_path)) }}" alt="{{ $adv->name }}" class="w-24 h-24 sm:w-28 sm:h-28 rounded-full mx-auto object-cover border-2 border-amber-400 shadow-md">
                                    @else
                                        <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-amber-500/10 border-2 border-amber-400/60 mx-auto flex items-center justify-center text-4xl text-amber-300 shadow-inner">
                                            👤
                                        </div>
                                    @endif
                                </div>

                                <!-- Leader Name Below -->
                                <div class="font-tiro text-amber-200 font-extrabold text-base sm:text-lg leading-snug flex-1 flex items-center justify-center text-center">
                                    {{ $adv->name }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- 5. Organizers, Nivedak & Vineet Block -->
            @php
                $organizerSec = $shivir->sections->first(function($sec) {
                    return str_contains($sec->title, 'आयोजक') || str_contains($sec->title, 'निवेदक') || str_contains($sec->title, 'विनीत');
                });
            @endphp

            @if($organizerSec && $organizerSec->activeItems->count() > 0)
                @php
                    $groupedOrganizers = $organizerSec->activeItems->groupBy('designation');
                @endphp
                
                <div class="pt-6 max-w-5xl mx-auto text-center space-y-6">
                    @foreach($groupedOrganizers as $headerTitle => $orgMembers)
                        <div class="space-y-2">
                            <!-- Golden Header Title -->
                            <div class="font-tiro text-amber-400 font-extrabold text-2xl sm:text-3xl leading-snug">
                                {{ $headerTitle }}
                            </div>

                            <!-- Member Name & Phone Numbers -->
                            <div class="space-y-1">
                                @foreach($orgMembers as $om)
                                    @if(trim($om->name) !== trim($headerTitle) && !str_contains($headerTitle, $om->name))
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
@if(!str_contains($sec->title, 'पुण्यार्जक') && !str_contains($sec->title, 'निर्देशक') && !str_contains($sec->title, 'प्रबन्ध') && !str_contains($sec->title, 'आयोजक') && !str_contains($sec->title, 'निवेदक') && !str_contains($sec->title, 'विनीत') && !str_contains($sec->title, 'आशीर्वाद') && !str_contains($sec->title, 'सानिध्य') && !str_contains($sec->title, 'धर्मानुरागी') && !str_contains($sec->title, 'जय जिनेन्द्र') && !str_contains($sec->title, 'आमंत्रण'))
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





<!-- Direct Embedded Registration Form Section -->
<section id="registration-form-section" class="bg-amber-50/40 py-8 border-t-4 border-amber-500">
    @include('public.partials.registration_form')
</section>

@endsection
