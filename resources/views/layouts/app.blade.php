<!DOCTYPE html>
<html lang="hi" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'श्रावक संस्कार शिविर | पुण्योदय भारत' }}</title>
    
    <!-- Google Fonts Hindi Devanagari -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari:wght@400;500;600;700;800&family=Tiro+Devanagari+Hindi:ital@0;1&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN & Alpine.js -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        maroon: {
                            50: '#fff1f2',
                            100: '#ffe4e6',
                            700: '#9f1239',
                            800: '#800020', // Jain Primary Maroon
                            900: '#580016',
                        },
                        amberGold: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                            600: '#d97706',
                            700: '#b45309',
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
    
    <style>
        body { font-family: 'Noto Sans Devanagari', sans-serif; background-color: #fdfbf7; color: #1f2937; }
        .gradient-header { background: linear-gradient(135deg, #800020 0%, #580016 100%); }
        .gold-border { border-color: #d97706; }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-amber-200 selection:text-maroon-900">

    <!-- Top Announcement Bar -->
    <div class="bg-amber-600 text-white text-xs md:text-sm py-1.5 px-4 text-center font-medium tracking-wide shadow-sm flex items-center justify-center gap-2">
        <span>🚩 33वाँ श्रावक संस्कार शिविर – अशोकनगर (म.प्र.) 2026 | परम पूज्य निर्यापक श्रमण मुनिश्री 108 सुधासागर जी महाराज</span>
    </div>

    <!-- Main Navigation Header -->
    <header class="gradient-header text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo & Brand Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-full bg-amber-500 border-2 border-amber-300 flex items-center justify-center font-bold text-white text-xl shadow">
                        🚩
                    </div>
                    <div>
                        <div class="font-tiro text-2xl sm:text-3xl font-bold tracking-tight text-amber-200">पुण्योदय भारत</div>
                        <div class="text-xs sm:text-sm text-amber-100/90 font-medium">वार्षिक श्रावक संस्कार शिविर प्रणाली</div>
                    </div>
                </a>

                <!-- Desktop Navigation with Explicit Spacing & No Text Wrapping -->
                <nav class="hidden xl:flex items-center gap-3 text-sm font-semibold">
                    <a href="{{ route('home') }}" class="hover:text-amber-300 transition px-2.5 py-1.5 rounded-lg hover:bg-maroon-700/50 whitespace-nowrap">मुख्य पृष्ठ</a>
                    <a href="{{ route('registration.status') }}" class="hover:text-amber-300 transition px-2.5 py-1.5 rounded-lg hover:bg-maroon-700/50 whitespace-nowrap">पंजीयन स्थिति</a>
                    <a href="{{ route('archive.index') }}" class="hover:text-amber-300 transition px-2.5 py-1.5 rounded-lg hover:bg-maroon-700/50 whitespace-nowrap">पिछले शिविर</a>
                    
                    <!-- Prominent Online Registration Form Button (Single Line) -->
                    <a href="{{ route('registration.create', 'sanskar-shivir-ashoknagar-2026') }}" class="bg-amber-500 hover:bg-amber-600 text-maroon-950 font-extrabold px-3.5 py-2 rounded-xl transition shadow-md flex items-center gap-1.5 border border-amber-300 whitespace-nowrap text-sm transform hover:-translate-y-0.5">
                        🚩 ऑनलाइन पंजीयन फॉर्म
                    </a>

                    <a href="{{ route('registration.status') }}" class="bg-maroon-900/90 hover:bg-maroon-800 text-amber-200 font-bold px-3 py-2 rounded-xl transition border border-amber-400/40 flex items-center gap-1 text-xs whitespace-nowrap">
                        🔍 पर्ची प्रिंट करें
                    </a>

                    @auth
                        <a href="{{ auth()->user()->canManageAttendance() && !auth()->user()->isAdmin() ? route('staff.scan') : route('admin.dashboard') }}" class="bg-amber-700 hover:bg-amber-800 text-white font-bold px-3 py-2 rounded-xl border border-amber-400/40 transition text-xs whitespace-nowrap">
                            डैशबोर्ड ({{ auth()->user()->name }})
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-amber-200 hover:text-white transition px-2.5 py-1.5 text-xs border border-amber-400/30 rounded-xl whitespace-nowrap">
                            स्टाफ / एडमिन
                        </a>
                    @endauth
                </nav>

                <!-- Medium Screens / Mobile Nav Dropdown Button -->
                <div class="xl:hidden flex items-center space-x-2 space-x-reverse" x-data="{ open: false }">
                    <a href="{{ route('registration.create', 'sanskar-shivir-ashoknagar-2026') }}" class="bg-amber-500 hover:bg-amber-600 text-maroon-950 font-extrabold px-3 py-1.5 rounded-lg text-xs border border-amber-300 whitespace-nowrap">
                        🚩 पंजीयन फॉर्म
                    </a>

                    <button @click="open = !open" class="p-2 rounded-md text-amber-200 hover:text-white hover:bg-maroon-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Mobile Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition class="absolute top-20 left-0 right-0 bg-maroon-900 border-b border-amber-600/30 p-4 space-y-3 shadow-xl">
                        <a href="{{ route('registration.create', 'sanskar-shivir-ashoknagar-2026') }}" class="block bg-amber-500 text-maroon-950 font-extrabold text-center py-3 rounded-xl shadow border-2 border-amber-300">
                            🚩 ऑनलाइन संस्कार शिविर पंजीयन फॉर्म
                        </a>
                        <a href="{{ route('home') }}" class="block text-white font-medium py-2 px-3 rounded hover:bg-maroon-800">मुख्य पृष्ठ</a>
                        <a href="{{ route('registration.status') }}" class="block text-white font-medium py-2 px-3 rounded hover:bg-maroon-800">पंजीयन स्थिति देखें / प्रिंट करें</a>
                        <a href="{{ route('archive.index') }}" class="block text-white font-medium py-2 px-3 rounded hover:bg-maroon-800">पिछले शिविर आर्काइव</a>
                        @auth
                            <a href="{{ route('admin.dashboard') }}" class="block bg-amber-700 text-white font-medium text-center py-2 rounded-lg">
                                एडमिन पैनल ({{ auth()->user()->name }})
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block text-amber-200 py-2 text-center text-sm">स्टाफ / एडमिन लॉगिन</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Session Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
        @if(session('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-600 text-emerald-800 p-4 rounded-r-lg shadow-sm flex items-center justify-between mb-4">
                <div class="flex items-center gap-2 font-medium">
                    <span>✅</span>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border-l-4 border-rose-600 text-rose-800 p-4 rounded-r-lg shadow-sm flex items-center justify-between mb-4">
                <div class="flex items-center gap-2 font-medium">
                    <span>⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Dynamic Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Spiritual Footer -->
    <footer class="gradient-header text-amber-100/90 mt-16 pt-12 pb-8 border-t-4 border-amber-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pb-8 border-b border-amber-600/30">
                <div>
                    <h3 class="font-tiro text-2xl font-bold text-amber-300 mb-3">पुण्योदय भारत</h3>
                    <p class="text-sm leading-relaxed text-amber-100/80">
                        परम पूज्य निर्यापक श्रमण मुनिश्री 108 सुधासागर जी महाराज के पावन आशीर्वाद एवं मार्गदर्शन में संचालित वार्षिक 10 दिवसीय श्रावक संस्कार शिविर प्रबंधन प्रणाली।
                    </p>
                </div>
                <div>
                    <h4 class="font-semibold text-white text-lg mb-3">त्वरित संपर्क हेल्प लाइन</h4>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-center gap-2">📞 +91 94251 23456 (अशोकनगर आयोजक समिति)</li>
                        <li class="flex items-center gap-2">📞 +91 98262 67890 (आवास एवं पंजीयन सहायता)</li>
                        <li class="flex items-center gap-2">📧 info@punyodaya.in</li>
                        <li class="flex items-center gap-2">📍 श्री दिगंबर जैन मंदिर परिसर, अशोकनगर (म.प्र.)</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white text-lg mb-3">महत्वपूर्ण सूचना</h4>
                    <p class="text-xs leading-relaxed bg-maroon-900/60 p-3 rounded-lg border border-amber-500/30 text-amber-200">
                        यह संस्कार शिविर केवल पुरुष वर्ग हेतु है। शिविर अवधि के दौरान मोबाइल फोन एवं इलेक्ट्रॉनिक गैजेट्स का प्रयोग पूर्णतः प्रतिबंधित है।
                    </p>
                </div>
            </div>

            <div class="pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-amber-200/70 gap-4">
                <div>© {{ date('Y') }} पुण्योदय भारत | बहु-वर्षीय संस्कार शिविर प्रबंधन प्रणाली | सर्व अधिकार सुरक्षित</div>
                <div class="flex gap-4">
                    <a href="{{ route('login') }}" class="hover:underline">प्रशासकीय लॉगिन</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
