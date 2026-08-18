@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <!-- Header Action Card -->
    <div class="bg-white p-6 rounded-3xl border border-amber-200 shadow-md flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-1">
                <a href="{{ route('admin.registrations.index') }}" class="text-xs font-bold text-amber-800 hover:underline">
                    ⬅ वापस पंजीयन सूची पर जाएं
                </a>
                <span class="text-slate-300">|</span>
                <span class="text-xs font-bold text-slate-500">पंजीयन क्रमांक: {{ $registration->registration_number }}</span>
            </div>
            <h1 class="font-tiro text-3xl font-extrabold text-maroon-900">{{ $registration->participant->full_name }}</h1>
            <p class="text-xs text-slate-600 font-medium">पिता: {{ $registration->participant->father_name }} | शहर: {{ $registration->participant->city }} ({{ $registration->participant->district }}, {{ $registration->participant->state }})</p>
        </div>

        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('registration.slip.pdf', $registration->registration_number) }}" class="bg-maroon-800 hover:bg-maroon-900 text-amber-300 font-bold px-4 py-2.5 rounded-xl text-sm shadow transition flex items-center gap-1.5">
                📥 PDF पंजीयन पर्ची
            </a>

            <!-- Quick Status Change Form -->
            <form action="{{ route('admin.registrations.update-status', $registration->id) }}" method="POST" class="inline flex items-center gap-2">
                @csrf
                @method('PUT')
                <select name="status" onchange="this.form.submit()" class="px-3 py-2 rounded-xl border border-slate-300 font-bold text-xs bg-white text-slate-800 focus:ring-2 focus:ring-amber-500">
                    <option value="approved" {{ $registration->status === 'approved' ? 'selected' : '' }}>Approved (स्वीकृत)</option>
                    <option value="checked_in" {{ $registration->status === 'checked_in' ? 'selected' : '' }}>Checked In (उपस्थित)</option>
                    <option value="pending" {{ $registration->status === 'pending' ? 'selected' : '' }}>Pending (लंबित)</option>
                    <option value="cancelled" {{ $registration->status === 'cancelled' ? 'selected' : '' }}>Cancelled (निरस्त)</option>
                </select>
            </form>
        </div>
    </div>

    <!-- Master Grid for All Form Details -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

        <!-- Left Column: Form Steps Data (8 Cols) -->
        <div class="lg:col-span-8 space-y-6">

            <!-- 1. Step 1: Personal Details -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="font-tiro text-xl font-bold text-maroon-900 border-b pb-2 flex items-center gap-2">
                    <span>👤</span> <span>चरण 1: व्यक्तिगत विवरण (Personal Information)</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">पूरा नाम (Full Name):</span>
                        <strong class="text-slate-900 text-base font-bold">{{ $registration->participant->full_name }}</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">पिता का नाम (Father's Name):</span>
                        <strong class="text-slate-900 text-base">{{ $registration->participant->father_name }}</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">माता का नाम (Mother's Name):</span>
                        <strong class="text-slate-900">{{ $registration->participant->mother_name ?? 'उपलब्ध नहीं' }}</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">आयु एवं जन्मतिथि (Age & DOB):</span>
                        <strong class="text-slate-900">{{ $registration->participant->age }} वर्ष ({{ $registration->participant->dob->format('d/m/Y') }})</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">पंजीकृत मोबाइल नंबर:</span>
                        <strong class="text-slate-900 font-mono text-base">{{ $registration->participant->mobile }}</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">व्हाट्सएप नंबर:</span>
                        <strong class="text-slate-900 font-mono text-base">{{ $registration->participant->whatsapp ?? $registration->participant->mobile }}</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 sm:col-span-2">
                        <span class="text-xs text-slate-500 block font-bold">ईमेल आईडी (Email):</span>
                        <strong class="text-slate-900">{{ $registration->participant->email ?? 'उपलब्ध नहीं' }}</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 sm:col-span-2">
                        <span class="text-xs text-slate-500 block font-bold">स्थाई पूरा पता (Full Address):</span>
                        <strong class="text-slate-900 text-base leading-relaxed">{{ $registration->participant->address }}</strong>
                        <div class="text-xs text-slate-600 font-bold mt-1">
                            शहर: {{ $registration->participant->city }} | जिला: {{ $registration->participant->district }} | राज्य: {{ $registration->participant->state }} | पिनकोड: {{ $registration->participant->pincode }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Step 2: Social & Background Details -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="font-tiro text-xl font-bold text-maroon-900 border-b pb-2 flex items-center gap-2">
                    <span>💼</span> <span>चरण 2: सामाजिक एवं पारिवारिक विवरण (Social & Background)</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">शैक्षणिक योग्यता (Education):</span>
                        <strong class="text-slate-900">{{ $registration->participant->education ?? 'उपलब्ध नहीं' }}</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">व्यवसाय / पेशा (Occupation):</span>
                        <strong class="text-slate-900">{{ $registration->participant->occupation ?? 'उपलब्ध नहीं' }}</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">पारिवारिक विवरण (Family Info):</span>
                        <strong class="text-slate-900">{{ $registration->participant->family_info ?? 'संयुक्त परिवार' }}</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">सामाजिक संस्था का नाम:</span>
                        <strong class="text-slate-900">{{ $registration->participant->social_org ?? 'सकल दिगंबर जैन समाज' }}</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">संस्था में पद (Position):</span>
                        <strong class="text-slate-900">{{ $registration->participant->social_position ?? 'सदस्य' }}</strong>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                        <span class="text-xs text-slate-500 block font-bold">पूर्व संस्कार शिविर सहभागिता:</span>
                        <strong class="text-maroon-900 font-bold">
                            {{ $registration->participant->previous_shivir_attended ? ('हाँ (' . $registration->participant->previous_shivir_count . ' बार भाग लिया)') : 'प्रथम बार (पहला शिविर)' }}
                        </strong>
                    </div>
                </div>
            </div>

            <!-- 3. Step 3: Emergency & Health Details -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="font-tiro text-xl font-bold text-maroon-900 border-b pb-2 flex items-center gap-2">
                    <span>🚨</span> <span>चरण 3: आपात्कालीन संपर्क विवरण (Emergency Contact)</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                    <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl">
                        <span class="text-xs text-rose-800 font-bold block">संपर्क व्यक्ति का नाम:</span>
                        <strong class="text-slate-900 text-base font-bold">{{ $registration->participant->emergency_contact_name }}</strong>
                    </div>
                    <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl">
                        <span class="text-xs text-rose-800 font-bold block">आपातकालीन मोबाइल नंबर:</span>
                        <strong class="text-slate-900 text-base font-mono font-bold">{{ $registration->participant->emergency_contact_number }}</strong>
                    </div>
                    <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl">
                        <span class="text-xs text-amber-800 font-bold block">रक्त समूह (Blood Group):</span>
                        <strong class="text-slate-900 text-base font-bold">{{ $registration->participant->blood_group ?? 'ज्ञात नहीं' }}</strong>
                    </div>
                </div>
            </div>

            <!-- 4. Step 4: Documents Upload Status -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-4">
                <h3 class="font-tiro text-xl font-bold text-maroon-900 border-b pb-2 flex items-center gap-2">
                    <span>📁</span> <span>चरण 4: पासपोर्ट फोटो एवं पहचान पत्र (Documents)</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-500 font-bold block">पासपोर्ट साइज फोटो</span>
                            <strong class="text-slate-900">{{ $registration->participant->photo_path ? 'अपलोड किया गया है' : 'डिफ़ॉल्ट सिस्टम प्रोफाइल' }}</strong>
                        </div>
                        @if($registration->participant->photo_path)
                            <a href="{{ asset('storage/' . $registration->participant->photo_path) }}" target="_blank" class="bg-amber-500 text-maroon-900 font-bold text-xs px-3 py-1.5 rounded-lg shadow">
                                फोटो देखें ↗
                            </a>
                        @endif
                    </div>

                    <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-500 font-bold block">पहचान पत्र (ID Document)</span>
                            <strong class="text-slate-900">{{ $registration->participant->id_document_path ? 'अपलोड किया गया है' : 'स्थान पर भौतिक सत्यापन' }}</strong>
                        </div>
                        @if($registration->participant->id_document_path)
                            <a href="{{ asset('storage/' . $registration->participant->id_document_path) }}" target="_blank" class="bg-amber-500 text-maroon-900 font-bold text-xs px-3 py-1.5 rounded-lg shadow">
                                दस्तावेज़ देखें ↗
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- 5. Step 5: Declaration & Rules Acceptance -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-3">
                <h3 class="font-tiro text-xl font-bold text-maroon-900 border-b pb-2 flex items-center gap-2">
                    <span>📋</span> <span>चरण 5: नियम स्वीकृति एवं घोषणा</span>
                </h3>

                <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-2xl flex items-center gap-3">
                    <span class="text-2xl text-emerald-700 font-bold">✓</span>
                    <div>
                        <div class="font-bold text-emerald-900 text-sm">नियम स्वीकृति घोषणा पत्र स्वीकार किया गया है</div>
                        <div class="text-xs text-emerald-800">
                            "मैंने संस्कार शिविर के सभी नियम एवं निर्देश ध्यानपूर्वक पढ़ लिए हैं तथा मैं उनका पूर्ण निष्ठा से पालन करने के लिए सहमत हूँ।" (मोबाइल फोन उपयोग निषेध नियम सहित)
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Right Column: Registration Summary & Venue Logistics (4 Cols) -->
        <div class="lg:col-span-4 space-y-6">

            <!-- Registration Master Badge Card -->
            <div class="bg-white rounded-3xl border-2 border-amber-400 shadow-md p-6 space-y-4 text-center">
                <span class="text-xs font-bold text-amber-800 uppercase tracking-wider block">पंजीयन आईडी (Reg ID)</span>
                
                <div class="font-tiro text-3xl font-extrabold text-maroon-900">{{ $registration->registration_number }}</div>

                <div class="inline-block px-4 py-1.5 rounded-full font-bold text-sm capitalize
                    {{ $registration->status === 'checked_in' ? 'bg-emerald-100 text-emerald-800 border border-emerald-300' : 'bg-amber-100 text-amber-800 border border-amber-300' }}">
                    {{ $registration->status === 'checked_in' ? '✓ Checked In (उपस्थित)' : 'स्वीकृत (Approved)' }}
                </div>

                <div class="text-xs text-slate-500 border-t pt-3 space-y-1 text-left">
                    <div><strong>शिविर:</strong> {{ $registration->shivir->name }}</div>
                    <div><strong>पंजीयन दिनांक:</strong> {{ $registration->created_at->format('d/m/Y h:i A') }}</div>
                    @if($registration->checked_in_at)
                        <div class="text-emerald-700 font-bold"><strong>वेन्यू चेक-इन:</strong> {{ $registration->checked_in_at->format('d/m/Y h:i A') }}</div>
                    @endif
                </div>
            </div>

            <!-- Accommodation Room Allocation Details Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-3">
                <h4 class="font-tiro text-lg font-bold text-maroon-900 border-b pb-2 flex items-center gap-1.5">
                    <span>🛏️</span> <span>आवास एवं कमरा आवंटन</span>
                </h4>
                
                @if($registration->roomAllocation)
                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 space-y-1">
                        <div class="text-xs text-amber-800 font-bold uppercase">आवंटित आवास ब्लॉक</div>
                        <div class="font-tiro text-xl font-extrabold text-maroon-900">
                            {{ $registration->roomAllocation->bed->room->block->name }}
                        </div>
                        <div class="text-sm font-bold text-slate-800">
                            कमरा संख्या: {{ $registration->roomAllocation->bed->room->room_number }} ({{ $registration->roomAllocation->bed->bed_number }})
                        </div>
                        <div class="text-xs text-slate-500 pt-1">
                            तल: {{ $registration->roomAllocation->bed->room->floor ?? 'प्रथम तल' }}
                        </div>
                        <div class="text-xs text-slate-500">
                            आवंटन समय: {{ $registration->roomAllocation->allocated_at->format('d/m/Y h:i A') }}
                        </div>
                    </div>
                @else
                    <div class="p-4 bg-slate-50 rounded-2xl text-center text-xs text-slate-500 font-medium border border-slate-200">
                        अभी कमरा आवंटित नहीं है। शिविर स्थल अशोकनगर पहुंचने पर रूम प्रबंधक द्वारा आवंटित किया जाएगा।
                    </div>
                @endif
            </div>

            <!-- Group Assignment Details Card -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-3">
                <h4 class="font-tiro text-lg font-bold text-maroon-900 border-b pb-2 flex items-center gap-1.5">
                    <span>👥</span> <span>आवंटित साधना समूह / बैच</span>
                </h4>
                
                @if($registration->groupMembers->first())
                    <div class="p-4 bg-indigo-50 rounded-2xl border border-indigo-200 text-indigo-900 space-y-1">
                        <div class="font-bold text-base">{{ $registration->groupMembers->first()->group->name }}</div>
                        <div class="text-xs text-indigo-800">समूह प्रमुख: {{ $registration->groupMembers->first()->group->leader_name ?? 'N/A' }}</div>
                        <div class="text-xs text-indigo-800">संपर्क: {{ $registration->groupMembers->first()->group->leader_contact ?? 'N/A' }}</div>
                        <div class="text-xs text-indigo-800">बैठक स्थान: {{ $registration->groupMembers->first()->group->meeting_point ?? 'N/A' }}</div>
                    </div>
                @else
                    <div class="p-4 bg-slate-50 rounded-2xl text-center text-xs text-slate-500 font-medium border border-slate-200">
                        साधना समूह आवंटित नहीं है।
                    </div>
                @endif
            </div>

            <!-- Attendance History Log -->
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 space-y-3">
                <h4 class="font-tiro text-lg font-bold text-maroon-900 border-b pb-2 flex items-center gap-1.5">
                    <span>⏱️</span> <span>सत्र उपस्थिति रिकॉर्ड</span>
                </h4>
                
                @if($registration->attendanceRecords->count() > 0)
                    <div class="space-y-2">
                        @foreach($registration->attendanceRecords as $att)
                            <div class="p-2.5 bg-emerald-50 rounded-xl border border-emerald-200 text-xs">
                                <div class="font-bold text-emerald-900">{{ $att->session->session_name }}</div>
                                <div class="text-[11px] text-emerald-700">{{ $att->scanned_at->format('d/m/Y h:i A') }}</div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="p-3 bg-slate-50 rounded-xl text-center text-xs text-slate-500">
                        कोई उपस्थिति रिकॉर्ड नहीं है।
                    </div>
                @endif
            </div>

        </div>

    </div>

</div>
@endsection
