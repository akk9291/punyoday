@extends('layouts.admin')

@section('content')
<div class="space-y-6" x-data="{ showModal: false, activeReg: null }">

    <!-- Filter & Header Card -->
    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b pb-4">
            <div>
                <h1 class="font-tiro text-2xl font-bold text-slate-900">पंजीयन सूची एवं संपूर्ण विवरण प्रबंधन (Registrations Manager)</h1>
                <p class="text-xs text-slate-500 mt-1">किसी भी प्रतिभागी की संपूर्ण फॉर्म जानकारी देखने के लिए 👁️ या Reg ID पर क्लिक करें।</p>
            </div>

            <div>
                <a href="{{ route('admin.reports.export-registrations', $shivir->id) }}" class="bg-emerald-700 hover:bg-emerald-800 text-white font-extrabold px-4 py-2 rounded-xl text-sm shadow flex items-center gap-1.5">
                    📊 Excel / CSV एक्सपोर्ट करें
                </a>
            </div>
        </div>

        <form action="{{ route('admin.registrations.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-3">
            <input type="hidden" name="shivir_id" value="{{ $shivir->id }}">

            <input type="text" name="search" value="{{ request('search') }}" placeholder="पंजीयन संख्या, नाम, मोबाइल, शहर..." class="px-4 py-2.5 rounded-xl border border-slate-300 font-medium text-sm">

            <select name="status" class="px-4 py-2.5 rounded-xl border border-slate-300 font-medium text-sm bg-white">
                <option value="">-- सभी स्थिति (Status) --</option>
                <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved (स्वीकृत)</option>
                <option value="checked_in" {{ request('status') === 'checked_in' ? 'selected' : '' }}>Checked In (उपस्थित)</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending (लंबित)</option>
            </select>

            <select name="room_status" class="px-4 py-2.5 rounded-xl border border-slate-300 font-medium text-sm bg-white">
                <option value="">-- आवास आवंटन स्थिति --</option>
                <option value="allocated" {{ request('room_status') === 'allocated' ? 'selected' : '' }}>कमरा आवंटित</option>
                <option value="unallocated" {{ request('room_status') === 'unallocated' ? 'selected' : '' }}>कमरा बिना-आवंटित</option>
            </select>

            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold px-4 py-2.5 rounded-xl text-sm shadow">
                🔍 खोजें (Filter)
            </button>
        </form>
    </div>

    <!-- Registrations Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold border-b text-xs uppercase tracking-wider">
                        <th class="py-3.5 px-4">Reg ID</th>
                        <th class="py-3.5 px-4">प्रतिभागी का नाम</th>
                        <th class="py-3.5 px-4">पिता का नाम</th>
                        <th class="py-3.5 px-4">आयु / मोबाइल</th>
                        <th class="py-3.5 px-4">नगर एवं जिला</th>
                        <th class="py-3.5 px-4">स्थिति (Status)</th>
                        <th class="py-3.5 px-4">आवंटित कमरा</th>
                        <th class="py-3.5 px-4 text-right">कार्रवाई (Action)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($registrations as $reg)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3.5 px-4 font-mono font-bold">
                                <a href="{{ route('admin.registrations.show', $reg->id) }}" class="text-maroon-900 hover:underline">
                                    {{ $reg->registration_number }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 font-bold">
                                <a href="{{ route('admin.registrations.show', $reg->id) }}" class="text-slate-900 hover:text-amber-800 hover:underline">
                                    {{ $reg->participant->full_name }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 text-slate-700">{{ $reg->participant->father_name }}</td>
                            <td class="py-3.5 px-4 text-xs">
                                <div>{{ $reg->participant->age }} वर्ष</div>
                                <div class="text-slate-500 font-mono">{{ $reg->participant->mobile }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-xs font-medium text-slate-700">
                                {{ $reg->participant->city }} ({{ $reg->participant->district }})
                            </td>
                            <td class="py-3.5 px-4">
                                <span class="px-2.5 py-1 rounded-full text-xs font-bold capitalize 
                                    {{ $reg->status === 'checked_in' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                    {{ $reg->status }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 text-xs font-bold text-amber-800">
                                {{ $reg->roomAllocation ? ($reg->roomAllocation->bed->room->block->name . ' - ' . $reg->roomAllocation->bed->room->room_number) : 'आवंटित नहीं' }}
                            </td>
                            <td class="py-3.5 px-4 text-right space-x-2 whitespace-nowrap">
                                <a href="{{ route('admin.registrations.show', $reg->id) }}" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold text-xs px-3 py-1.5 rounded-lg shadow inline-block">
                                    🔍 संपूर्ण विवरण देखें
                                </a>
                                <a href="{{ route('registration.slip.pdf', $reg->registration_number) }}" class="text-slate-600 hover:text-slate-900 font-bold text-xs inline-block">
                                    📄 PDF
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t">
            {{ $registrations->links() }}
        </div>
    </div>

</div>
@endsection
