<!DOCTYPE html>
<html lang="hi" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'एडमिन पैनल | संस्कार शिविर प्रबंधन' }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;500;600;700;800&family=Tiro+Devanagari+Hindi&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: {
                            800: '#800020',
                            900: '#580016',
                        }
                    },
                    fontFamily: {
                        hindi: ['"Noto Sans Devanagari"', 'sans-serif'],
                        tiro: ['"Tiro Devanagari Hindi"', 'serif'],
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-slate-100 font-hindi text-slate-800 antialiased min-h-screen flex flex-col">

    <!-- Top Admin Header -->
    <header class="bg-maroon-900 text-white shadow sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-3 space-x-reverse">
                    <a href="{{ route('admin.dashboard') }}" class="font-tiro text-xl font-bold text-amber-300">
                        🚩 संस्कार शिविर कंट्रोल पैनल
                    </a>
                </div>

                <div class="flex items-center space-x-4 space-x-reverse">
                    <!-- Quick Staff Scan link -->
                    <a href="{{ route('staff.scan') }}" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 text-sm font-bold px-3 py-1.5 rounded-lg shadow flex items-center gap-1">
                        📷 QR स्कैनर
                    </a>

                    <!-- User Profile info -->
                    <div class="text-right text-xs hidden sm:block">
                        <div class="font-bold text-amber-200">{{ auth()->user()->name }}</div>
                        <div class="text-amber-100/70 capitalize">रोल: {{ auth()->user()->role }}</div>
                    </div>

                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-rose-700 hover:bg-rose-800 text-white text-xs px-3 py-1.5 rounded-md font-medium">
                            लॉगआउट
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Admin Body Container with Sidebar & Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 flex-grow w-full grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Sidebar Navigation -->
        <aside class="lg:col-span-3">
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-4 sticky top-20 space-y-1">
                <div class="px-3 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">प्रशासकीय मॉड्यूल</div>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.dashboard') ? 'bg-amber-100 text-maroon-900 font-bold border-r-4 border-amber-600' : 'text-slate-700 hover:bg-slate-50' }}">
                    📊 मुख्य डैशबोर्ड (Stats)
                </a>

                <a href="{{ route('admin.shivirs.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.shivirs.*') ? 'bg-amber-100 text-maroon-900 font-bold border-r-4 border-amber-600' : 'text-slate-700 hover:bg-slate-50' }}">
                    🗓️ बहु-वर्षीय शिविर प्रबंधन
                </a>

                <a href="{{ route('admin.cms.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.cms.*') ? 'bg-amber-100 text-maroon-900 font-bold border-r-4 border-amber-600' : 'text-slate-700 hover:bg-slate-50' }}">
                    🎨 डायनामिक CMS अनुभाग
                </a>

                <a href="{{ route('admin.registrations.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.registrations.*') ? 'bg-amber-100 text-maroon-900 font-bold border-r-4 border-amber-600' : 'text-slate-700 hover:bg-slate-50' }}">
                    📋 पंजीयन सूची एवं सत्यापन
                </a>

                <a href="{{ route('admin.accommodation.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.accommodation.*') ? 'bg-amber-100 text-maroon-900 font-bold border-r-4 border-amber-600' : 'text-slate-700 hover:bg-slate-50' }}">
                    🛏️ कमरा एवं आवास प्रबंधन
                </a>

                <a href="{{ route('admin.attendance.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.attendance.*') ? 'bg-amber-100 text-maroon-900 font-bold border-r-4 border-amber-600' : 'text-slate-700 hover:bg-slate-50' }}">
                    ⏱️ सत्र उपस्थिति एवं स्कैनर
                </a>

                <a href="{{ route('admin.certificates.index') }}" class="flex items-center gap-2.5 px-3 py-2.5 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.certificates.*') ? 'bg-amber-100 text-maroon-900 font-bold border-r-4 border-amber-600' : 'text-slate-700 hover:bg-slate-50' }}">
                    📜 प्रमाण पत्र मॉड्यूल
                </a>

                <div class="pt-4 border-t border-slate-200 px-3 py-2 text-xs font-bold text-slate-400 uppercase tracking-wider">साइट पर जाएं</div>

                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-2 px-3 py-2 rounded-lg text-sm text-amber-700 hover:bg-amber-50 font-medium">
                    🌐 सार्वजनिक वेबसाइट देखें ↗
                </a>
            </div>
        </aside>

        <!-- Main Content View -->
        <main class="lg:col-span-9 space-y-6">
            @if(session('success'))
                <div class="bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 p-4 rounded-r-lg shadow-sm font-medium">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-rose-50 border-l-4 border-rose-600 text-rose-800 p-4 rounded-r-lg shadow-sm font-medium">
                    ⚠️ {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
