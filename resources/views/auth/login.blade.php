@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto px-4 py-12">
    
    <div class="bg-white rounded-3xl shadow-xl border border-amber-200 p-8 space-y-6">
        
        <div class="text-center">
            <div class="w-14 h-14 bg-maroon-800 text-amber-300 rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-3 shadow">
                🔐
            </div>
            <h1 class="font-tiro text-3xl font-bold text-maroon-900">स्टाफ एवं प्रशासक लॉगिन</h1>
            <p class="text-slate-600 text-sm mt-1">संस्कार शिविर प्रबंधन पोर्टल</p>
        </div>

        @if ($errors->any())
            <div class="bg-rose-50 border-l-4 border-rose-600 text-rose-800 p-3 rounded-r-lg text-sm font-medium">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block font-bold text-slate-700 text-sm mb-1">ईमेल (Email Address)</label>
                <input type="email" name="email" id="login_email" value="{{ old('email', 'admin@punyodaya.in') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
            </div>

            <div>
                <label class="block font-bold text-slate-700 text-sm mb-1">पासवर्ड (Password)</label>
                <input type="password" name="password" id="login_password" value="password" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="inline-flex items-center gap-2 text-slate-600">
                    <input type="checkbox" name="remember" class="w-4 h-4 text-amber-600 rounded">
                    <span>मुझे याद रखें</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-maroon-800 hover:bg-maroon-900 text-amber-300 font-extrabold py-3.5 rounded-xl shadow transition text-base border-2 border-amber-500">
                लॉगिन करें ➔
            </button>
        </form>

        <!-- Quick Demo Credentials Selector -->
        <div class="pt-6 border-t border-slate-200">
            <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-2 text-center">त्वरित परीक्षण लॉगिन (Quick Demo Users)</div>
            <div class="grid grid-cols-2 gap-2 text-xs">
                <button type="button" onclick="setCredentials('superadmin@punyodaya.in')" class="p-2 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg font-semibold text-amber-900 text-left">
                    👑 Super Admin
                </button>
                <button type="button" onclick="setCredentials('admin@punyodaya.in')" class="p-2 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg font-semibold text-amber-900 text-left">
                    🛡️ Admin
                </button>
                <button type="button" onclick="setCredentials('regmanager@punyodaya.in')" class="p-2 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg font-semibold text-amber-900 text-left">
                    📋 Reg Manager
                </button>
                <button type="button" onclick="setCredentials('roommanager@punyodaya.in')" class="p-2 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg font-semibold text-amber-900 text-left">
                    🛏️ Room Manager
                </button>
                <button type="button" onclick="setCredentials('attendancemanager@punyodaya.in')" class="p-2 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg font-semibold text-amber-900 text-left">
                    ⏱️ Attendance Staff
                </button>
                <button type="button" onclick="setCredentials('volunteer@punyodaya.in')" class="p-2 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg font-semibold text-amber-900 text-left">
                    🙋 Volunteer
                </button>
            </div>
            <p class="text-[11px] text-slate-400 text-center mt-2">सभी का डिफ़ॉल्ट पासवर्ड: <code class="bg-slate-100 px-1 py-0.5 rounded font-mono text-slate-700">password</code></p>
        </div>

    </div>

</div>

<script>
    function setCredentials(email) {
        document.getElementById('login_email').value = email;
        document.getElementById('login_password').value = 'password';
    }
</script>
@endsection
