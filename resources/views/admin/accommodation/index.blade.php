@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ showBlockModal: false, showRoomModal: false, activeBlockId: null }">

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="font-tiro text-2xl font-bold text-slate-900">आवास एवं कमरा प्रबंधन (Accommodation & Room Allocations)</h1>
            <p class="text-xs text-slate-500 mt-1">ब्लॉक, कमरा संख्या, बिस्तरों की कुल क्षमता एवं वर्तमान कब्जा जांचें।</p>
        </div>

        <div class="flex items-center gap-3">
            <button @click="showBlockModal = true" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold px-4 py-2 rounded-xl text-sm shadow">
                🏢 नया आवास ब्लॉक जोड़ें
            </button>
        </div>
    </div>

    <!-- Blocks Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($blocks as $block)
            <div class="bg-white rounded-2xl border border-amber-200 shadow-sm p-6 space-y-4">
                <div class="flex items-center justify-between border-b pb-3">
                    <div>
                        <h3 class="font-tiro text-2xl font-bold text-maroon-900">{{ $block->name }}</h3>
                        <p class="text-xs text-slate-500">{{ $block->description }}</p>
                    </div>

                    <button @click="showRoomModal = true; activeBlockId = {{ $block->id }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1.5 rounded-lg text-xs shadow">
                        🔑 नया कमरा जोड़ें
                    </button>
                </div>

                <!-- Rooms Accordion/Grid -->
                <div class="space-y-3">
                    @foreach($block->rooms as $room)
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                            <div class="flex items-center justify-between mb-2">
                                <span class="font-bold text-slate-900 text-base">कमरा नं. {{ $room->room_number }} (क्षमता: {{ $room->capacity }})</span>
                                <span class="text-xs font-semibold text-slate-500">{{ $room->floor }}</span>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-xs">
                                @foreach($room->beds as $bed)
                                    <div class="p-2 rounded-lg border text-center font-bold {{ $bed->is_occupied ? 'bg-amber-100 text-amber-900 border-amber-300' : 'bg-emerald-50 text-emerald-800 border-emerald-300' }}">
                                        <div>{{ $bed->bed_number }}</div>
                                        <div class="text-[10px] font-normal">
                                            @if($bed->is_occupied && $bed->allocation)
                                                {{ $bed->allocation->registration->participant->full_name }}
                                            @else
                                                खाली (Available)
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Block -->
    <div x-show="showBlockModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4">
            <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">नया आवास ब्लॉक जोड़ें</h3>
            <form action="{{ route('admin.accommodation.block.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="shivir_id" value="{{ $shivir->id }}">
                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">ब्लॉक का नाम *</label>
                    <input type="text" name="name" required placeholder="उदा. ब्लॉक सी (पारसनाथ भवन)" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">विवरण</label>
                    <textarea name="description" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium"></textarea>
                </div>
                <div class="flex justify-end gap-3 border-t pt-4">
                    <button type="button" @click="showBlockModal = false" class="bg-slate-200 font-bold px-4 py-2 rounded-xl text-sm">रद्द करें</button>
                    <button type="submit" class="bg-amber-500 text-maroon-900 font-extrabold px-6 py-2 rounded-xl text-sm shadow">सहेजें</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Room -->
    <div x-show="showRoomModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4">
            <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">नया कमरा जोड़ें</h3>
            <form action="{{ route('admin.accommodation.room.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="accommodation_block_id" :value="activeBlockId">
                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">कमरा संख्या (Room Number) *</label>
                    <input type="text" name="room_number" required placeholder="105" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">बिस्तर क्षमता (Capacity) *</label>
                    <input type="number" name="capacity" value="4" min="1" max="20" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>
                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">तल / मंज़िल (Floor)</label>
                    <input type="text" name="floor" placeholder="प्रथम तल" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>
                <div class="flex justify-end gap-3 border-t pt-4">
                    <button type="button" @click="showRoomModal = false" class="bg-slate-200 font-bold px-4 py-2 rounded-xl text-sm">रद्द करें</button>
                    <button type="submit" class="bg-amber-500 text-maroon-900 font-extrabold px-6 py-2 rounded-xl text-sm shadow">कमरा सहेजें</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
