@extends('layouts.admin')

@section('content')
<div class="space-y-6">

    <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <h1 class="font-tiro text-2xl font-bold text-slate-900">प्रमाण पत्र मॉड्यूल (Certificates Generator)</h1>
            <p class="text-xs text-slate-500 mt-1">शिविर समाप्ति के बाद सभी उपस्थित प्रतिभागियों के लिए क्यूआर कोड युक्त प्रमाण पत्र जारी करें।</p>
        </div>

        <form action="{{ route('admin.certificates.generate-bulk', $shivir->id) }}" method="POST">
            @csrf
            <button type="submit" onclick="return confirm('क्या आप सभी उपस्थित शिविरार्थियों के लिए प्रमाण पत्र जनरेट करना चाहते हैं?')" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold px-5 py-2.5 rounded-xl shadow transition text-sm flex items-center gap-1.5">
                📜 प्रमाण पत्र थोक जनरेट करें (Generate Bulk)
            </button>
        </form>
    </div>

    <!-- Certificates Table -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 font-bold border-b text-xs uppercase tracking-wider">
                        <th class="py-3.5 px-4">Cert Number</th>
                        <th class="py-3.5 px-4">Reg ID</th>
                        <th class="py-3.5 px-4">प्रतिभागी का नाम</th>
                        <th class="py-3.5 px-4">जारी तिथि</th>
                        <th class="py-3.5 px-4 text-right">प्रमाण पत्र डाउनलोड</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($certificates as $cert)
                        <tr class="hover:bg-slate-50">
                            <td class="py-3.5 px-4 font-mono font-bold text-maroon-900">{{ $cert->certificate_number }}</td>
                            <td class="py-3.5 px-4 font-mono text-slate-700">{{ $cert->registration->registration_number }}</td>
                            <td class="py-3.5 px-4 font-bold text-slate-900">{{ $cert->registration->participant->full_name }}</td>
                            <td class="py-3.5 px-4 text-xs text-slate-600">{{ $cert->issued_date->format('d/m/Y') }}</td>
                            <td class="py-3.5 px-4 text-right">
                                <a href="{{ route('admin.certificates.pdf', $cert->id) }}" class="bg-maroon-800 hover:bg-maroon-900 text-amber-300 font-bold px-3 py-1.5 rounded-lg text-xs transition inline-block">
                                    📥 PDF सर्टिफिकेट
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="p-4 border-t">
            {{ $certificates->links() }}
        </div>
    </div>

</div>
@endsection
