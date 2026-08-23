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
        @media (min-width: 1024px) {
            .lg\:text-3xl {
                font-size: 1.675rem;
                line-height: 2.25rem;
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased selection:bg-amber-200 selection:text-maroon-900">

    <!-- Top Color Line Accent -->
    <div class="bg-amber-500 h-2 w-full shadow-sm"></div>

    <!-- Main Navigation Header -->
    <header class="gradient-header text-white sticky top-0 z-50 shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo & Brand Name -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="पुण्योदय logo" class="h-12 sm:h-16 w-auto object-contain drop-shadow-lg transform hover:scale-105 transition duration-300">
                    <div>
                        <div class="font-tiro text-2xl sm:text-3xl font-bold tracking-tight text-amber-200">पुण्योदय विद्यापथ</div>
                    </div>
                </a>

                <!-- Desktop Navigation with Explicit Spacing & No Text Wrapping -->
                <nav class="hidden xl:flex items-center gap-3 text-sm font-semibold">
                    <a href="{{ route('home') }}" class="hover:text-amber-300 transition px-2.5 py-1.5 rounded-lg hover:bg-maroon-700/50 whitespace-nowrap">मुख्य पृष्ठ</a>
                    <a href="{{ route('registration.status') }}" class="hover:text-amber-300 transition px-2.5 py-1.5 rounded-lg hover:bg-maroon-700/50 whitespace-nowrap">पंजीयन स्थिति</a>
                    
                    <!-- Right Side Social Media Icons (YouTube, Instagram, Facebook, WhatsApp) -->
                    <div class="flex items-center gap-2 pl-2 border-l border-amber-500/30">
                        <!-- YouTube -->
                        <a href="https://www.youtube.com/@punyodayavidyapath" target="_blank" title="YouTube" class="w-8 h-8 rounded-full bg-red-600 hover:bg-red-500 text-white flex items-center justify-center shadow transition transform hover:scale-110">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>

                        <!-- Instagram -->
                        <a href="https://www.instagram.com/punyodayavidyapath" target="_blank" title="Instagram" class="w-8 h-8 rounded-full bg-gradient-to-tr from-amber-500 via-rose-500 to-purple-600 hover:opacity-90 text-white flex items-center justify-center shadow transition transform hover:scale-110">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        </a>

                        <!-- Facebook -->
                        <a href="https://www.facebook.com/punyodayavidyapath" target="_blank" title="Facebook" class="w-8 h-8 rounded-full bg-blue-600 hover:bg-blue-500 text-white flex items-center justify-center shadow transition transform hover:scale-110">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>

                        <!-- WhatsApp (Original WhatsApp Green & Icon) -->
                        <a href="https://wa.me/917898888668" target="_blank" title="WhatsApp" class="w-8 h-8 rounded-full bg-[#25D366] hover:bg-[#20ba5a] text-white flex items-center justify-center shadow transition transform hover:scale-110">
                            <svg class="w-4.5 h-4.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                        </a>
                    </div>
                </nav>

                <!-- Medium Screens / Mobile Nav Dropdown Button -->
                <div class="xl:hidden flex items-center space-x-2 space-x-reverse" x-data="{ open: false }">
                    <button @click="open = !open" class="p-2 rounded-md text-amber-200 hover:text-white hover:bg-maroon-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>

                    <!-- Mobile Dropdown -->
                    <div x-show="open" @click.away="open = false" x-transition class="absolute top-20 left-0 right-0 bg-maroon-900 border-b border-amber-600/30 p-4 space-y-3 shadow-xl">
                        <a href="{{ route('home') }}" class="block text-white font-medium py-2 px-3 rounded hover:bg-maroon-800">मुख्य पृष्ठ</a>
                        <a href="{{ route('registration.status') }}" class="block text-white font-medium py-2 px-3 rounded hover:bg-maroon-800">पंजीयन स्थिति देखें</a>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Header Banner Image Slider (Multi-Image Auto Carousel) -->
    <div class="bg-amber-950 border-b-4 border-amber-500 shadow-xl overflow-hidden relative"
         x-data="{
            activeBanner: 0,
            banners: [
                '{{ asset('images/banner_slider_1.png') }}',
                '{{ asset('images/banner_slider_2.jpg') }}',
                '{{ asset('images/banner_slider_3.jpg') }}'
            ],
            init() {
                setInterval(() => {
                    this.activeBanner = (this.activeBanner + 1) % this.banners.length;
                }, 4000);
            }
         }">
        
        <div class="max-w-7xl mx-auto px-2 sm:px-4 relative py-2 sm:py-3 min-h-[160px] sm:min-h-[220px] md:min-h-[280px] flex items-center justify-center">
            <template x-for="(banner, index) in banners" :key="index">
                <div class="absolute inset-0 flex items-center justify-center p-2 transition-opacity duration-700 ease-in-out"
                     :class="activeBanner === index ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none'">
                    <img :src="banner" alt="पुण्योदय विद्यापथ" class="w-full h-auto max-h-48 sm:max-h-64 md:max-h-72 lg:max-h-80 object-contain rounded-xl shadow-lg">
                </div>
            </template>
        </div>

        <!-- Slider Arrow Buttons & Dot Indicators -->
        <div class="absolute bottom-2 left-0 right-0 z-20 flex items-center justify-center gap-3">
            <button @click="activeBanner = (activeBanner - 1 + banners.length) % banners.length" title="पिछला" class="w-7 h-7 rounded-full bg-maroon-950/80 hover:bg-amber-500 hover:text-maroon-950 text-amber-200 border border-amber-400/50 shadow transition transform hover:scale-110 flex items-center justify-center font-bold text-xs">
                ❮
            </button>
            <div class="flex items-center gap-1.5">
                <template x-for="(banner, index) in banners" :key="index">
                    <button @click="activeBanner = index" 
                            class="h-2 rounded-full transition-all duration-300 shadow"
                            :class="activeBanner === index ? 'w-6 bg-amber-400' : 'w-2 bg-white/50 hover:bg-white/80'">
                    </button>
                </template>
            </div>
            <button @click="activeBanner = (activeBanner + 1) % banners.length" title="अगला" class="w-7 h-7 rounded-full bg-maroon-950/80 hover:bg-amber-500 hover:text-maroon-950 text-amber-200 border border-amber-400/50 shadow transition transform hover:scale-110 flex items-center justify-center font-bold text-xs">
                ❯
            </button>
        </div>
    </div>

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
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/logo.png') }}" alt="पुण्योदय logo" class="h-12 w-auto object-contain">
                        <h3 class="font-tiro text-2xl font-bold text-amber-300">पुण्योदय विद्यापथ</h3>
                    </div>
                    <p class="text-sm leading-relaxed text-amber-100/80">
                        परम पूज्य निर्यापक श्रमण मुनिश्री १०८ सुधासागर जी महाराज के पावन आशीर्वाद एवं मार्गदर्शन में संचालित वार्षिक 10 दिवसीय श्रावक संस्कार शिविर प्रबंधन प्रणाली।
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
