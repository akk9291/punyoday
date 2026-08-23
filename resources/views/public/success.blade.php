@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="bg-white rounded-3xl shadow-2xl border-2 border-amber-400 overflow-hidden text-center">
        
        <!-- Header Banner -->
        <div class="bg-emerald-700 text-white p-8">
            <div class="w-16 h-16 bg-white text-emerald-700 rounded-full flex items-center justify-center text-3xl font-bold mx-auto mb-3 shadow">
                ✓
            </div>
            <h1 class="font-tiro text-3xl sm:text-4xl font-bold text-amber-200 mb-1">जय जिनेन्द्र! पंजीयन सफल हुआ</h1>
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

            <!-- 2-Column Social & Varshayog Group Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <!-- Left Column: Social Media Handles Invite Banner -->
                <div class="bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 rounded-2xl p-5 border-2 border-amber-300 shadow-lg text-maroon-950 flex flex-col justify-between space-y-4">
                    <div class="font-tiro font-extrabold text-base sm:text-lg leading-snug text-center drop-shadow-sm">
                        इंदौर शिविर की समस्त फोटो एल्बम, लाइव प्रसारण लिंक, विशेष वीडियो एवं रील प्राप्त करने के लिए पुण्योदय विद्यापथ चैनल के सोशल मीडिया हैंडल्स से जुड़िये:
                    </div>

                    <div class="flex flex-col gap-2.5 pt-1">
                        <!-- 1. YouTube Channel -->
                        <a href="https://www.youtube.com/@punyodayavidyapath" target="_blank" rel="noopener noreferrer" class="bg-red-600 hover:bg-red-700 text-white font-bold text-xs sm:text-sm px-4 py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 fill-current text-white flex-shrink-0" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            <span>यूट्यूब चैनल Subscribe करे (1,32,000 Subscribers)</span>
                        </a>

                        <!-- 2. Instagram Page -->
                        <a href="https://www.instagram.com/punyodayavidyapath" target="_blank" rel="noopener noreferrer" class="bg-gradient-to-tr from-amber-500 via-rose-600 to-purple-600 hover:opacity-95 text-white font-bold text-xs sm:text-sm px-4 py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 fill-current text-white flex-shrink-0" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                            <span>इन्स्टाग्राम पेज follow करे (61,500 Followers)</span>
                        </a>

                        <!-- 3. Facebook Page -->
                        <a href="https://www.facebook.com/punyodayavidyapath" target="_blank" rel="noopener noreferrer" class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs sm:text-sm px-4 py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 fill-current text-white flex-shrink-0" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            <span>फेसबुक पेज follow करे (92,000 Followers)</span>
                        </a>

                        <!-- 4. WhatsApp Channel -->
                        <a href="https://whatsapp.com/channel/0029VaOMwvf002T5or071M3u" target="_blank" rel="noopener noreferrer" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs sm:text-sm px-4 py-3 rounded-xl shadow-md transition flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                            <svg class="w-5 h-5 fill-current text-emerald-100 flex-shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                            <span>व्हाट्सप्प चैनल से जुड़िये (12,000 Followers)</span>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Indore Varshayog WhatsApp Group Banner -->
                <div class="bg-gradient-to-r from-amber-500 via-amber-400 to-amber-500 rounded-2xl p-5 border-2 border-amber-300 shadow-lg text-maroon-950 flex flex-col justify-between items-center text-center space-y-4">
                    <!-- Heading -->
                    <div class="font-tiro font-extrabold text-base sm:text-lg leading-snug drop-shadow-sm">
                        इंदौर वर्षायोग के व्हाट्सएप ग्रुप से जुड़िये
                    </div>

                    <!-- Poster Circle Graphic -->
                    <div class="relative w-44 h-44 sm:w-48 sm:h-48 rounded-full overflow-hidden border-4 border-amber-300 shadow-xl mx-auto my-1 transform hover:scale-105 transition duration-300">
                        <img src="{{ asset('images/indore_varshayog.jpg') }}" alt="इंदौर वर्षायोग" class="w-full h-full object-cover">
                    </div>

                    <!-- Member Count Subtitle -->
                    <div class="bg-maroon-900/10 text-maroon-950 border border-maroon-900/20 px-4 py-1.5 rounded-full font-bold text-xs sm:text-sm inline-block">
                        व्हाट्सप्प ग्रुप – 55,000+ Members
                    </div>

                    <!-- Join WhatsApp Group Button -->
                    <a href="https://chat.whatsapp.com/K9Cl5ATw0PCFrgJghgSw0p" target="_blank" rel="noopener noreferrer" class="w-full bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold text-sm sm:text-base py-3.5 px-6 rounded-xl shadow-lg transition flex items-center justify-center gap-2 transform hover:-translate-y-0.5">
                        <svg class="w-6 h-6 fill-current text-emerald-200 flex-shrink-0" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        <span>व्हाट्सएप ग्रुप से जुड़िये</span>
                    </a>
                </div>
            </div>



        </div>

    </div>

</div>
@endsection
