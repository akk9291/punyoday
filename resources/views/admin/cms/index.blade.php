@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{
    showSecModal: false,
    showEditSecModal: false,
    editSec: { id: null, title: '', subtitle: '', description: '', sort_order: 1 },

    showItemModal: false,
    showEditItemModal: false,
    activeSecId: null,
    editItem: { id: null, name: '', designation: '', department: '', mobile: '', description: '', sort_order: 1 }
}">

    <!-- Header Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="font-tiro text-2xl font-bold text-slate-900">डायनामिक CMS अनुभाग एवं व्यक्ति प्रबंधन (Dynamic CMS)</h1>
            <p class="text-xs text-slate-500 mt-1">वेबसाइट के लिए असीमित अनुभाग, संयोजक, मुनिराज, पुण्यार्जक एवं समितियां जोड़ें व सम्पादित करें।</p>
        </div>

        <div class="flex items-center gap-3">
            <form action="{{ route('admin.cms.index') }}" method="GET">
                <select name="shivir_id" onchange="this.form.submit()" class="px-4 py-2 rounded-xl border border-slate-300 font-bold text-sm bg-white">
                    @foreach($shivirs as $s)
                        <option value="{{ $s->id }}" {{ $currentShivir && $currentShivir->id === $s->id ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
            </form>

            <button @click="showSecModal = true" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold px-4 py-2 rounded-xl text-sm shadow">
                ➕ नया अनुभाग (Section) जोड़ें
            </button>
        </div>
    </div>

    <!-- CMS Sections Listing -->
    <div class="space-y-6">
        @foreach($sections as $sec)
            <div class="bg-white rounded-2xl border border-amber-200 shadow-sm p-6 space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between border-b pb-3 gap-3">
                    <div>
                        <span class="text-xs font-bold text-amber-700 uppercase tracking-wider block">क्रम: {{ $sec->sort_order }}</span>
                        <h3 class="font-tiro text-2xl font-bold text-maroon-900">{{ $sec->title }}</h3>
                        @if($sec->subtitle)
                            <div class="text-xs text-slate-500 font-medium mt-0.5">{{ $sec->subtitle }}</div>
                        @endif
                        @if($sec->description)
                            <div class="text-xs text-slate-600 mt-1 line-clamp-2">{!! nl2br(e($sec->description)) !!}</div>
                        @endif
                    </div>

                    <div class="flex items-center gap-2 self-start sm:self-auto">
                        <button @click="showItemModal = true; activeSecId = {{ $sec->id }}" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-3 py-1.5 rounded-lg text-xs shadow">
                            ➕ व्यक्ति/संयोजक जोड़ें
                        </button>
                        
                        <button @click="editSec = { 
                            id: {{ $sec->id }}, 
                            title: '{{ addslashes($sec->title) }}', 
                            subtitle: '{{ addslashes($sec->subtitle ?? '') }}', 
                            description: '{{ addslashes(str_replace(["\r", "\n"], ['\r', '\n'], $sec->description ?? '')) }}', 
                            sort_order: {{ $sec->sort_order }} 
                        }; showEditSecModal = true" class="bg-amber-500 hover:bg-amber-600 text-maroon-950 font-bold px-3 py-1.5 rounded-lg text-xs shadow">
                            ✏️ सम्पादित करें
                        </button>

                        <form action="{{ route('admin.cms.section.destroy', $sec->id) }}" method="POST" onsubmit="return confirm('क्या आप इस अनुभाग को हटाना चाहते हैं?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-rose-100 text-rose-700 font-bold px-3 py-1.5 rounded-lg text-xs">
                                🗑️ हटाएँ
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Section Person Items Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pt-2">
                    @foreach($sec->items as $item)
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 flex items-start justify-between gap-2 shadow-sm">
                            <div class="space-y-1 flex-1">
                                <div class="font-bold text-slate-900 text-sm sm:text-base">{{ $item->name }}</div>
                                @if($item->designation)
                                    <div class="text-xs font-bold text-amber-800">{{ $item->designation }}</div>
                                @endif
                                @if($item->department)
                                    <div class="text-xs text-slate-600 font-medium">{{ $item->department }}</div>
                                @endif
                                @if($item->mobile)
                                    <div class="text-[11px] text-slate-500 font-mono">📞 {{ $item->mobile }}</div>
                                @endif
                            </div>

                            <div class="flex items-center gap-1">
                                <button type="button" @click="editItem = { 
                                    id: {{ $item->id }}, 
                                    name: '{{ addslashes($item->name) }}', 
                                    designation: '{{ addslashes($item->designation ?? '') }}', 
                                    department: '{{ addslashes($item->department ?? '') }}', 
                                    mobile: '{{ addslashes($item->mobile ?? '') }}', 
                                    description: '{{ addslashes(str_replace(["\r", "\n"], ['\r', '\n'], $item->description ?? '')) }}', 
                                    sort_order: {{ $item->sort_order }} 
                                }; showEditItemModal = true" class="text-amber-800 hover:text-amber-950 font-bold text-xs p-1.5 bg-amber-100 rounded-md hover:bg-amber-200" title="सम्पादित करें">
                                    ✏️
                                </button>
                                
                                <form action="{{ route('admin.cms.item.destroy', $item->id) }}" method="POST" onsubmit="return confirm('क्या आप इस सदस्य को हटाना चाहते हैं?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:text-rose-800 text-xs font-bold p-1.5 bg-rose-100 rounded-md hover:bg-rose-200" title="हटाएँ">
                                        ×
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- 1. Modal for Adding New Section -->
    <div x-show="showSecModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4">
            <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">नया CMS अनुभाग (Section) बनाएं</h3>

            <form action="{{ route('admin.cms.section.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="shivir_id" value="{{ $currentShivir->id }}">

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">अनुभाग शीर्षक (Title) *</label>
                    <input type="text" name="title" required placeholder="उदा. शिविर निर्देशक एवं संयोजक" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">उपशीर्षक (Subtitle)</label>
                    <input type="text" name="subtitle" placeholder="उदा. अशोकनगर कार्यसमिति" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">विवरण / पत्र सामग्री (Description)</label>
                    <textarea name="description" rows="3" placeholder="अनुभाग का विवरण या पत्र पाठ..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">क्रम संख्या (Sort Order)</label>
                    <input type="number" name="sort_order" value="1" class="w-24 px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div class="flex justify-end gap-3 border-t pt-4">
                    <button type="button" @click="showSecModal = false" class="bg-slate-200 font-bold px-4 py-2 rounded-xl text-sm">रद्द करें</button>
                    <button type="submit" class="bg-amber-500 text-maroon-900 font-extrabold px-6 py-2 rounded-xl text-sm shadow">सहेजें</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 2. Modal for Editing Section -->
    <div x-show="showEditSecModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4">
            <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">अनुभाग सम्पादित करें (Edit Section)</h3>

            <form :action="'{{ url('admin/cms/section') }}/' + editSec.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">अनुभाग शीर्षक (Title) *</label>
                    <input type="text" name="title" x-model="editSec.title" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">उपशीर्षक (Subtitle)</label>
                    <input type="text" name="subtitle" x-model="editSec.subtitle" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">विवरण / पत्र सामग्री (Description)</label>
                    <textarea name="description" rows="4" x-model="editSec.description" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">क्रम संख्या (Sort Order)</label>
                    <input type="number" name="sort_order" x-model="editSec.sort_order" class="w-24 px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div class="flex justify-end gap-3 border-t pt-4">
                    <button type="button" @click="showEditSecModal = false" class="bg-slate-200 font-bold px-4 py-2 rounded-xl text-sm">रद्द करें</button>
                    <button type="submit" class="bg-amber-500 text-maroon-900 font-extrabold px-6 py-2 rounded-xl text-sm shadow">अद्यतन करें (Update)</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 3. Modal for Adding New Person Item -->
    <div x-show="showItemModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4">
            <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">नया व्यक्ति / सदस्य जोड़ें</h3>

            <form action="{{ route('admin.cms.item.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="shivir_section_id" :value="activeSecId">

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">नाम / परिवार नाम (Name) *</label>
                    <input type="text" name="name" required placeholder="उदा. श्री मनोज जैन टप्पू" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">पद / दायित्व (Designation)</label>
                    <input type="text" name="designation" placeholder="उदा. मुख्य संयोजक / आयोजक" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">विभाग / सदस्य सूची / विवरण (Department)</label>
                    <textarea name="department" rows="2" placeholder="उदा. परिवार के सदस्यों के नाम..." class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">मोबाइल नंबर</label>
                    <input type="text" name="mobile" placeholder="9425122222" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div class="flex justify-end gap-3 border-t pt-4">
                    <button type="button" @click="showItemModal = false" class="bg-slate-200 font-bold px-4 py-2 rounded-xl text-sm">रद्द करें</button>
                    <button type="submit" class="bg-amber-500 text-maroon-900 font-extrabold px-6 py-2 rounded-xl text-sm shadow">सहेजें</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 4. Modal for Editing Person Item -->
    <div x-show="showEditItemModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl p-6 sm:p-8 max-w-lg w-full shadow-2xl space-y-4">
            <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">व्यक्ति / सदस्य सम्पादित करें (Edit Item)</h3>

            <form :action="'{{ url('admin/cms/item') }}/' + editItem.id" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">नाम / परिवार नाम (Name) *</label>
                    <input type="text" name="name" x-model="editItem.name" required class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">पद / दायित्व (Designation)</label>
                    <input type="text" name="designation" x-model="editItem.designation" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">विभाग / सदस्य सूची / विवरण (Department)</label>
                    <textarea name="department" rows="3" x-model="editItem.department" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium"></textarea>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">मोबाइल नंबर</label>
                    <input type="text" name="mobile" x-model="editItem.mobile" class="w-full px-4 py-2.5 rounded-xl border border-slate-300 font-medium">
                </div>

                <div class="flex justify-end gap-3 border-t pt-4">
                    <button type="button" @click="showEditItemModal = false" class="bg-slate-200 font-bold px-4 py-2 rounded-xl text-sm">रद्द करें</button>
                    <button type="submit" class="bg-amber-500 text-maroon-900 font-extrabold px-6 py-2 rounded-xl text-sm shadow">अद्यतन करें (Update)</button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
