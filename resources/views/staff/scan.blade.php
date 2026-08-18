@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="staffScanner()">

    <!-- Scanner Header Card -->
    <div class="bg-maroon-900 text-amber-200 p-6 sm:p-8 rounded-3xl shadow-xl border-2 border-amber-500 text-center mb-6">
        <span class="bg-amber-500 text-maroon-900 font-extrabold text-xs px-3 py-1 rounded-full uppercase tracking-wider mb-2 inline-block">
            📷 मोबाइल स्टाफ क्यूआर स्कैनर (Staff Venue Tool)
        </span>
        <h1 class="font-tiro text-3xl font-bold">क्यूआर कोड स्कैन एवं तुरंत सत्यापन</h1>
        <p class="text-xs sm:text-sm text-amber-100/90 mt-1">
            प्रतिभागी की पंजीयन पर्ची का क्यूआर कोड स्कैन करें या 10 अंकों का टोकन/पंजीयन आईडी दर्ज करें।
        </p>
    </div>

    <!-- Manual / Scanner Input Box -->
    <div class="bg-white rounded-3xl p-6 shadow-md border border-slate-200 mb-6">
        <label class="block font-bold text-slate-700 text-sm mb-2">क्यूआर कोड टोकन / पंजीयन क्रमांक (Scan or Enter Token)</label>
        <div class="flex gap-3">
            <input type="text" x-model="inputToken" @keyup.enter="lookupToken()" placeholder="उदा. ASH-2026-00001 अथवा क्यूआर टोकन" class="flex-grow px-4 py-3.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 text-base font-medium">
            <button @click="lookupToken()" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold px-6 py-3.5 rounded-xl shadow transition whitespace-nowrap">
                🔍 खोजें (Lookup)
            </button>
        </div>
        <p x-show="errorMessage" x-text="errorMessage" class="text-rose-600 font-bold text-sm mt-2"></p>
    </div>

    <!-- Participant Result Card Modal/Drawer -->
    <template x-if="participant">
        <div class="bg-white rounded-3xl shadow-2xl border-2 border-amber-500 p-6 sm:p-8 space-y-6">
            
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between border-b pb-4 gap-4">
                <div>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">पंजीयन क्रमांक</span>
                    <h2 class="font-tiro text-3xl font-extrabold text-maroon-900" x-text="participant.reg_no"></h2>
                </div>
                <div>
                    <span class="px-4 py-1.5 rounded-full text-sm font-bold" 
                          :class="participant.status === 'checked_in' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800'" 
                          x-text="participant.status === 'checked_in' ? '✓ Checked In (सत्यापित)' : 'स्वीकृत (Pending Checkin)'">
                    </span>
                </div>
            </div>

            <!-- Participant Info Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm bg-slate-50 p-6 rounded-2xl border border-slate-200">
                <div>
                    <span class="text-slate-500 text-xs block">शिविरार्थी नाम:</span>
                    <strong class="text-slate-900 text-lg font-bold" x-text="participant.name"></strong>
                </div>
                <div>
                    <span class="text-slate-500 text-xs block">पिता का नाम:</span>
                    <strong class="text-slate-900 text-base" x-text="participant.father_name"></strong>
                </div>
                <div>
                    <span class="text-slate-500 text-xs block">आयु एवं स्थान:</span>
                    <strong class="text-slate-900" x-text="participant.age + ' वर्ष (' + participant.city + ', ' + participant.district + ')'"></strong>
                </div>
                <div>
                    <span class="text-slate-500 text-xs block">मोबाइल नंबर:</span>
                    <strong class="text-slate-900" x-text="participant.mobile"></strong>
                </div>
                <div>
                    <span class="text-slate-500 text-xs block">आपातकालीन संपर्क:</span>
                    <strong class="text-slate-900" x-text="participant.emergency_contact"></strong>
                </div>
                <div>
                    <span class="text-slate-500 text-xs block">वर्तमान कमरा / आवास:</span>
                    <strong class="text-amber-800 bg-amber-100 px-2 py-1 rounded font-bold" x-text="participant.room_info"></strong>
                </div>
            </div>

            <!-- Quick Action Toolbar -->
            <div class="border-t pt-6 space-y-4">
                <div class="text-xs font-bold text-slate-400 uppercase tracking-wider">स्टाफ त्वरित कार्रवाई (Quick Staff Actions)</div>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <!-- Verify Check-in -->
                    <button @click="verifyCheckin()" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-4 py-3 rounded-xl shadow transition text-sm flex items-center justify-center gap-1.5">
                        ✓ [सत्यापन एवं चेक-इन]
                    </button>

                    <!-- Allocate Room Modal Trigger -->
                    <button @click="showRoomModal = true" class="bg-amber-600 hover:bg-amber-700 text-white font-bold px-4 py-3 rounded-xl shadow transition text-sm flex items-center justify-center gap-1.5">
                        🛏️ [कमरा आवंटन करें]
                    </button>

                    <!-- Attendance Mark -->
                    <button @click="markAttendance()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold px-4 py-3 rounded-xl shadow transition text-sm flex items-center justify-center gap-1.5">
                        ⏱️ [सत्र उपस्थिति दर्ज करें]
                    </button>
                </div>
            </div>

            <!-- Status Action Success Message -->
            <div x-show="actionMessage" class="p-4 bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 rounded-r-xl font-bold text-sm">
                <span x-text="actionMessage"></span>
            </div>

            <!-- Room Allocation Modal -->
            <div x-show="showRoomModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
                <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4 border border-amber-300">
                    <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">आवास / कमरा आवंटन</h3>
                    
                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">उपलब्ध कमरा एवं बिस्तर चुनें</label>
                        <select x-model="selectedBedId" class="w-full px-4 py-3 rounded-xl border border-slate-300 text-base font-medium">
                            <option value="">-- उपलब्ध बिस्तर का चयन करें --</option>
                            @foreach($blocks as $block)
                                @foreach($block->rooms as $room)
                                    @foreach($room->beds as $bed)
                                        <option value="{{ $bed->id }}">
                                            {{ $block->name }} - कमरा {{ $room->room_number }} ({{ $bed->bed_number }})
                                        </option>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <button @click="showRoomModal = false" class="bg-slate-200 text-slate-700 font-bold px-4 py-2 rounded-xl text-sm">रद्द करें</button>
                        <button @click="submitRoomAllocation()" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-bold px-6 py-2 rounded-xl text-sm shadow">आवंटन सहेजें</button>
                    </div>
                </div>
            </div>

        </div>
    </template>

</div>

<script>
    function staffScanner() {
        return {
            inputToken: '',
            participant: null,
            errorMessage: '',
            actionMessage: '',
            showRoomModal: false,
            selectedBedId: '',
            lookupToken() {
                if (!this.inputToken) return;
                this.errorMessage = '';
                this.actionMessage = '';

                fetch('{{ route("staff.lookup") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ token: this.inputToken })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.participant = data.data;
                    } else {
                        this.errorMessage = data.message;
                        this.participant = null;
                    }
                })
                .catch(() => {
                    this.errorMessage = 'सर्वर से संपर्क करने में त्रुटि!';
                });
            },
            verifyCheckin() {
                fetch('/staff/verify/' + this.participant.id, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.actionMessage = data.message;
                        this.participant.status = 'checked_in';
                    }
                });
            },
            submitRoomAllocation() {
                if (!this.selectedBedId) return;
                fetch('/staff/allocate-room/' + this.participant.id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ bed_id: this.selectedBedId })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        this.actionMessage = data.message;
                        this.participant.room_info = data.room_info;
                        this.showRoomModal = false;
                    }
                });
            },
            markAttendance() {
                // Mark attendance for active session
                fetch('/staff/attendance/' + this.participant.id, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ session_id: 1 })
                })
                .then(res => res.json())
                .then(data => {
                    this.actionMessage = data.message;
                });
            }
        }
    }
</script>
@endsection
