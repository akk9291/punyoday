<div class="max-w-6xl mx-auto px-2 sm:px-4 lg:px-6 py-6" x-data="registrationForm()">

    <!-- Form Container with Soft Yellow Background -->
    <div class="bg-[#fffbeb] rounded-3xl shadow-xl border-2 border-amber-300 overflow-hidden">
        
        <!-- Form Header -->
        <div class="gradient-header text-white p-6 sm:p-8 text-center border-b-4 border-amber-500 space-y-3">
            <h2 class="font-tiro text-3xl sm:text-4xl font-bold text-amber-200">ऑनलाइन संस्कार शिविर पंजीयन फॉर्म</h2>
            <p class="text-amber-100 text-sm sm:text-base font-medium">{{ $shivir->name }}</p>

            <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-2 sm:gap-4 text-xs sm:text-sm font-semibold text-amber-200 bg-black/20 py-2.5 px-4 rounded-xl max-w-3xl mx-auto border border-amber-400/30">
                <span class="flex items-center gap-1">
                    <span class="text-rose-500 font-extrabold text-base">*</span> इस निशान वाले जानकारी को भरना अनिवार्य है।
                </span>
                <span class="hidden sm:inline text-amber-400">|</span>
                <span>
                    📜 नियम व शर्ते पढ़कर ही ऑनलाइन फॉर्म भरें।
                </span>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="m-6 p-4 bg-rose-50 border-l-4 border-rose-600 text-rose-800 rounded-r-lg text-sm">
                <div class="font-bold mb-1">कृपया निम्नलिखित त्रुटियों को सुधारें:</div>
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Client-Side Form Validation Error Alert -->
        <div x-show="formError" x-text="formError" class="m-6 p-4 bg-rose-100 border-l-4 border-rose-600 text-rose-900 rounded-r-lg font-bold text-sm"></div>

        <form action="{{ route('registration.store', $shivir->slug) }}" method="POST" enctype="multipart/form-data" class="p-4 sm:p-8 space-y-6" @submit="validateForm($event)">
            @csrf

            <!-- Form Fields Container -->
            <div class="space-y-5">
                
                <!-- Row 1: शिविरार्थी का नाम *, उपनाम * -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">शिविरार्थी का नाम <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="full_name" x-model="formData.full_name" placeholder="शिविरार्थी का नाम" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">उपनाम <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="surname" x-model="formData.surname" placeholder="उपनाम" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>
                </div>

                <!-- Row 2: पिता का नाम *, माता का नाम * -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">पिता का नाम <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="father_name" x-model="formData.father_name" placeholder="पिता का नाम" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">माता का नाम <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="mother_name" x-model="formData.mother_name" placeholder="माता का नाम" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>
                </div>

                <!-- Row 3: वैवाहिक विवरण *, जन्म दिनांक *, आयु * -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">वैवाहिक विवरण <span class="text-rose-600 font-bold">*</span></label>
                        <select name="marital_status" x-model="formData.marital_status" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                            <option value="वैवाहिक (married)">वैवाहिक (married)</option>
                            <option value="अविवाहित (unmarried)">अविवाहित (unmarried)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">जन्म दिनांक <span class="text-rose-600 font-bold">*</span></label>
                        <input type="date" name="dob" x-model="formData.dob" @change="calculateAge()" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">आयु <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="age" :value="calculatedAge !== null ? calculatedAge + ' वर्ष' : ''" placeholder="वर्तमान आयु" readonly class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/70 shadow-sm">
                    </div>
                </div>

                <!-- Row 4: ईमेल, मोबाईल नंबर *, व्हाट्सएप नंबर * -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">ईमेल</label>
                        <input type="email" name="email" x-model="formData.email" placeholder="ईमेल" class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">मोबाईल नंबर <span class="text-rose-600 font-bold">*</span></label>
                        <input type="tel" name="mobile" x-model="formData.mobile" maxlength="10" placeholder="मोबाईल नंबर" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">व्हाट्सएप नंबर <span class="text-rose-600 font-bold">*</span></label>
                        <input type="tel" name="whatsapp" x-model="formData.whatsapp" maxlength="10" placeholder="व्हाट्सएप नंबर" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>
                </div>

                <!-- Row 5: आपात्काल स्थिति में पारिवारिक सदस्य का नाम *, आपात्काल स्थिति में पारिवारिक सदस्य का नंबर *, सदस्य से रिश्ता * -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">आपातकाल स्थिति में पारिवारिक सदस्य का नाम <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="emergency_contact_name" x-model="formData.emergency_contact_name" placeholder="आपातकाल स्थिति में पारिवारिक सदस्य का नाम" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">आपातकाल स्थिति में पारिवारिक सदस्य का नंबर <span class="text-rose-600 font-bold">*</span></label>
                        <input type="tel" name="emergency_contact_number" x-model="formData.emergency_contact_number" maxlength="10" placeholder="आपातकाल स्थिति में पारिवारिक सदस्य का नंबर" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">सदस्य से रिश्ता <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="emergency_relation" x-model="formData.emergency_relation" placeholder="सदस्य से रिश्ता" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>
                </div>

                <!-- Row 6: आपका पता *, शहर * -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-maroon-950 text-sm mb-1">आपका पता <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="address" x-model="formData.address" placeholder="पता" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">शहर <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="city" x-model="formData.city" placeholder="शहर" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>
                </div>

                <!-- Row 7: जिला *, राज्य *, पिन कोड * -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">जिला <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="district" x-model="formData.district" placeholder="जिला" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">राज्य <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="state" x-model="formData.state" placeholder="राज्य" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">पिन कोड <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="pincode" x-model="formData.pincode" maxlength="6" placeholder="पिन कोड" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>
                </div>

                <!-- Row 8: शिक्षा विवरण *, परिवार के सदस्यों की कुल संख्या *, पारिवारिक व्यवसाय -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">शिक्षा विवरण <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="education" x-model="formData.education" placeholder="शिक्षा विवरण" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">परिवार के सदस्यों की कुल संख्या <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="family_members_count" x-model="formData.family_members_count" placeholder="परिवार के सदस्यों की कुल संख्या" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">पारिवारिक व्यवसाय</label>
                        <input type="text" name="family_occupation" x-model="formData.family_occupation" placeholder="पारिवारिक व्यवसाय" class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>
                </div>

                <!-- Row 9: किसी सामाजिक संस्था/कमेटी/ट्रस्ट से जुड़े हैं तो उसका नाम, संस्था में विशेष पद -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div class="sm:col-span-2">
                        <label class="block font-bold text-maroon-950 text-sm mb-1">किसी सामाजिक संस्था/कमेटी/ट्रस्ट से जुड़े हैं तो उसका नाम</label>
                        <input type="text" name="social_org" x-model="formData.social_org" placeholder="किसी सामाजिक संस्था/कमेटी/ट्रस्ट से जुड़े हैं तो उसका नाम" class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">संस्था में विशेष पद</label>
                        <input type="text" name="social_position" x-model="formData.social_position" placeholder="संस्था में विशेष पद" class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>
                </div>

                <!-- Row 10: पूर्व में श्री सुधासागर जी के शिविर में भाग लिया है क्या *, अगर हाँ तो कितनी बार -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 items-end">
                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">पूर्व में श्री सुधासागर जी के शिविर में भाग लिया है क्या <span class="text-rose-600 font-bold">*</span></label>
                        <div class="flex items-center gap-6 pt-1">
                            <label class="inline-flex items-center gap-2 font-bold text-slate-800 cursor-pointer">
                                <input type="radio" name="previous_shivir_attended" value="1" x-model="hasPrevious" class="w-4 h-4 text-amber-600 border-slate-300 focus:ring-amber-500">
                                <span>हाँ</span>
                            </label>
                            <label class="inline-flex items-center gap-2 font-bold text-slate-800 cursor-pointer">
                                <input type="radio" name="previous_shivir_attended" value="0" x-model="hasPrevious" class="w-4 h-4 text-amber-600 border-slate-300 focus:ring-amber-500">
                                <span>नहीं</span>
                            </label>
                        </div>
                    </div>

                    <div x-show="hasPrevious == '1'" x-transition class="transition-all duration-300">
                        <label class="block font-bold text-maroon-950 text-sm mb-1">अगर हाँ तो कितनी बार</label>
                        <input type="number" name="previous_shivir_count" value="{{ old('previous_shivir_count', 1) }}" min="1" max="30" placeholder="संख्या दर्ज करें" class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>
                </div>

                <!-- Row 11: आधार नंबर *, आधार फोटो (ऑनलाइन अनिवार्य नहीं), पासपोर्ट फोटो (ऑनलाइन अनिवार्य नहीं) -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">आधार नंबर <span class="text-rose-600 font-bold">*</span></label>
                        <input type="text" name="aadhaar_number" x-model="formData.aadhaar_number" maxlength="12" placeholder="आधार नंबर" required class="w-full px-4 py-2.5 rounded-lg border border-amber-200 focus:ring-2 focus:ring-amber-500 text-slate-800 text-base font-medium bg-white/90 shadow-sm">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">आधार फोटो (ऑनलाइन अनिवार्य नहीं)</label>
                        <input type="file" name="id_document" accept="image/*,.pdf" class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-200 file:text-maroon-950 hover:file:bg-amber-300 bg-white/90 border border-amber-200 rounded-lg p-1">
                    </div>

                    <div>
                        <label class="block font-bold text-maroon-950 text-sm mb-1">पासपोर्ट फोटो (ऑनलाइन अनिवार्य नहीं)</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-sm text-slate-600 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-amber-200 file:text-maroon-950 hover:file:bg-amber-300 bg-white/90 border border-amber-200 rounded-lg p-1">
                    </div>
                </div>

                <!-- Rules & Declaration Section -->
                <div class="pt-4 space-y-4">
                    <div class="bg-amber-900 text-amber-50 p-5 rounded-2xl border-2 border-amber-500 shadow-xl space-y-3">
                        <div class="flex items-center justify-between border-b border-amber-500/50 pb-2.5">
                            <h4 class="font-tiro font-bold text-amber-200 text-lg sm:text-xl flex items-center gap-2">
                                📜 <span>शिविर के आवश्यक नियम (कुल {{ $shivir->rules->count() }} नियम)</span>
                            </h4>
                            <span class="text-xs bg-amber-500 text-maroon-950 font-extrabold px-3 py-1 rounded-full uppercase">पढ़ना अनिवार्य है</span>
                        </div>

                        <div class="space-y-2.5">
                            @foreach($shivir->rules as $index => $rule)
                                <div class="bg-maroon-900/90 p-3 sm:p-3.5 rounded-xl border border-amber-500/40 flex items-start gap-3">
                                    <span class="bg-amber-500 text-maroon-950 font-extrabold text-xs px-2.5 py-0.5 rounded-md min-w-[26px] text-center mt-0.5 shadow-sm">
                                        {{ $index + 1 }}
                                    </span>
                                    <p class="text-xs sm:text-sm font-medium text-amber-100/95 leading-relaxed pt-0.5">
                                        {{ $rule->rule_text }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="p-5 bg-amber-100/90 border-2 border-amber-400 rounded-2xl shadow-sm">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="rules_accepted" value="1" x-model="formData.rules_accepted" class="w-6 h-6 text-amber-600 rounded border-slate-300 focus:ring-amber-500 mt-0.5">
                            <span class="font-bold text-maroon-950 text-base sm:text-lg leading-snug">
                                मैंने संस्कार शिविर के उपरोक्त सभी {{ $shivir->rules->count() }} नियमों एवं निर्देशों को ध्यानपूर्वक पढ़ लिया है तथा मैं उनका पूर्ण निष्ठा से पालन करने के लिए सहमत हूँ। <span class="text-rose-600 font-bold">*</span>
                            </span>
                        </label>
                    </div>

                    <div class="text-center pt-3">
                        <button type="submit" class="w-full sm:w-auto bg-maroon-800 hover:bg-maroon-900 text-amber-300 font-extrabold text-xl px-12 py-4 rounded-2xl shadow-2xl transition transform hover:-translate-y-0.5 border-2 border-amber-500 cursor-pointer">
                            पंजीयन फॉर्म जमा करें (Submit Registration)
                        </button>
                    </div>
                </div>

            </div>

        </form>
    </div>
</div>

<script>
    function registrationForm() {
        return {
            calculatedAge: null,
            hasPrevious: '{{ old('previous_shivir_attended', 0) }}',
            formError: '',
            formData: {
                full_name: '{{ old('full_name') }}',
                surname: '{{ old('surname') }}',
                father_name: '{{ old('father_name') }}',
                mother_name: '{{ old('mother_name') }}',
                marital_status: '{{ old('marital_status', 'अविवाहित (unmarried)') }}',
                dob: '{{ old('dob') }}',
                email: '{{ old('email') }}',
                mobile: '{{ old('mobile') }}',
                whatsapp: '{{ old('whatsapp') }}',
                emergency_contact_name: '{{ old('emergency_contact_name') }}',
                emergency_contact_number: '{{ old('emergency_contact_number') }}',
                emergency_relation: '{{ old('emergency_relation') }}',
                address: '{{ old('address') }}',
                city: '{{ old('city') }}',
                district: '{{ old('district') }}',
                state: '{{ old('state', 'मध्य प्रदेश') }}',
                pincode: '{{ old('pincode') }}',
                education: '{{ old('education') }}',
                family_members_count: '{{ old('family_members_count') }}',
                family_occupation: '{{ old('family_occupation') }}',
                social_org: '{{ old('social_org') }}',
                social_position: '{{ old('social_position') }}',
                aadhaar_number: '{{ old('aadhaar_number') }}',
                rules_accepted: false
            },
            calculateAge() {
                if (!this.formData.dob) return;
                const birthDate = new Date(this.formData.dob);
                const today = new Date();
                let age = today.getFullYear() - birthDate.getFullYear();
                const monthDiff = today.getMonth() - birthDate.getMonth();
                if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                this.calculatedAge = age;
            },
            validateForm(event) {
                this.formError = '';
                if (!this.formData.full_name || !this.formData.surname || !this.formData.father_name || !this.formData.mother_name || !this.formData.dob || !this.formData.mobile || !this.formData.whatsapp || !this.formData.address || !this.formData.city || !this.formData.district || !this.formData.state || !this.formData.pincode || !this.formData.emergency_contact_name || !this.formData.emergency_contact_number || !this.formData.emergency_relation || !this.formData.education || !this.formData.family_members_count || !this.formData.aadhaar_number) {
                    event.preventDefault();
                    this.formError = 'कृपया फॉर्म की सभी अनिवार्य (*) जानकारी दर्ज करें।';
                    window.scrollTo({ top: 150, behavior: 'smooth' });
                    return false;
                }
                if (this.formData.mobile.length < 10) {
                    event.preventDefault();
                    this.formError = 'कृपया 10 अंकों का वैध मोबाइल नंबर दर्ज करें।';
                    window.scrollTo({ top: 150, behavior: 'smooth' });
                    return false;
                }
                if (!this.formData.rules_accepted) {
                    event.preventDefault();
                    this.formError = 'शिविर के नियमों एवं घोषणा पत्र को स्वीकार करना अनिवार्य है।';
                    window.scrollTo({ top: 150, behavior: 'smooth' });
                    return false;
                }
            }
        }
    }
</script>
