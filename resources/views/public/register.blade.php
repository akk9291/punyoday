@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="registrationWizard()">

    <!-- Form Container -->
    <div class="bg-white rounded-3xl shadow-xl border border-amber-200 overflow-hidden">
        
        <!-- Form Header -->
        <div class="gradient-header text-white p-6 sm:p-8 text-center border-b-4 border-amber-500">
            <h1 class="font-tiro text-3xl sm:text-4xl font-bold text-amber-200 mb-2">ऑनलाइन संस्कार शिविर पंजीयन फॉर्म</h1>
            <p class="text-amber-100 text-sm sm:text-base font-medium">{{ $shivir->name }}</p>
        </div>

        <!-- Male-Only Notice Banner -->
        <div class="bg-amber-100 border-b border-amber-300 p-4 text-center">
            <div class="text-maroon-900 font-bold text-base flex items-center justify-center gap-2">
                <span>⚠️</span> <span>यह संस्कार शिविर केवल पुरुष वर्ग के लिए ही आयोजित है।</span>
            </div>
            <p class="text-xs text-amber-800 mt-1">
                शिविर अवधि के दौरान मोबाइल फोन एवं इलेक्ट्रॉनिक गैजेट्स रखना पूर्णतः प्रतिबंधित है।
            </p>
        </div>

        <!-- Progress Indicator Bar -->
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-200">
            <div class="flex items-center justify-between text-xs sm:text-sm font-bold text-slate-600 mb-2">
                <button type="button" @click="goToStep(1)" :class="step === 1 ? 'text-maroon-800 font-extrabold underline' : ''">1. व्यक्तिगत जानकारी</button>
                <button type="button" @click="goToStep(2)" :class="step === 2 ? 'text-maroon-800 font-extrabold underline' : ''">2. सामाजिक जानकारी</button>
                <button type="button" @click="goToStep(3)" :class="step === 3 ? 'text-maroon-800 font-extrabold underline' : ''">3. आपात्कालीन संपर्क</button>
                <button type="button" @click="goToStep(4)" :class="step === 4 ? 'text-maroon-800 font-extrabold underline' : ''">4. दस्तावेज़</button>
                <button type="button" @click="goToStep(5)" :class="step === 5 ? 'text-maroon-800 font-extrabold underline' : ''">5. नियम एवं घोषणा</button>
            </div>
            <div class="w-full bg-slate-200 h-2.5 rounded-full overflow-hidden">
                <div class="bg-amber-500 h-2.5 transition-all duration-300" :style="'width: ' + (step * 20) + '%'"></div>
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

        <!-- Client-Side Step Validation Error Alert -->
        <div x-show="stepError" x-text="stepError" class="m-6 p-4 bg-rose-100 border-l-4 border-rose-600 text-rose-900 rounded-r-lg font-bold text-sm"></div>

        <form action="{{ route('registration.store', $shivir->slug) }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-10 space-y-8">
            @csrf

            <!-- STEP 1: Personal Information -->
            <div x-show="step === 1" class="space-y-6">
                <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">चरण 1: आवेदक की व्यक्तिगत जानकारी</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">पूरा नाम (Full Name) <span class="text-rose-600">*</span></label>
                        <input type="text" name="full_name" x-model="formData.full_name" placeholder="उदा. अमित जैन" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">पिता का नाम (Father's Name) <span class="text-rose-600">*</span></label>
                        <input type="text" name="father_name" x-model="formData.father_name" placeholder="उदा. श्री हुकमचंद जैन" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">माता का नाम (Mother's Name)</label>
                        <input type="text" name="mother_name" value="{{ old('mother_name') }}" placeholder="उदा. श्रीमती सुशीला जैन" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">जन्म तिथि (Date of Birth) <span class="text-rose-600">*</span></label>
                        <input type="date" name="dob" x-model="formData.dob" @change="calculateAge()" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                        <div x-show="calculatedAge !== null" class="text-xs font-bold text-amber-800 mt-1">
                            आपकी अनुमानित आयु: <span x-text="calculatedAge"></span> वर्ष
                        </div>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">मोबाइल नंबर (10 Digit Mobile) <span class="text-rose-600">*</span></label>
                        <input type="tel" name="mobile" x-model="formData.mobile" maxlength="10" placeholder="9826012345" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">व्हाट्सएप नंबर (WhatsApp No)</label>
                        <input type="tel" name="whatsapp" value="{{ old('whatsapp') }}" maxlength="10" placeholder="9826012345" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-slate-200">
                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">स्थाई पता (Full Address) <span class="text-rose-600">*</span></label>
                        <textarea name="address" x-model="formData.address" rows="2" placeholder="मकान नंबर, गली/मोहल्ला, लैंडमार्क..." class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium"></textarea>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                        <div>
                            <label class="block font-bold text-slate-700 text-sm mb-1">शहर / नगर <span class="text-rose-600">*</span></label>
                            <input type="text" name="city" x-model="formData.city" placeholder="अशोकनगर" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 text-sm mb-1">जिला (District) <span class="text-rose-600">*</span></label>
                            <input type="text" name="district" x-model="formData.district" placeholder="अशोकनगर" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 text-sm mb-1">राज्य (State) <span class="text-rose-600">*</span></label>
                            <select name="state" x-model="formData.state" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                                <option value="मध्य प्रदेश">मध्य प्रदेश</option>
                                <option value="उत्तर प्रदेश">उत्तर प्रदेश</option>
                                <option value="राजस्थान">राजस्थान</option>
                                <option value="महाराष्ट्र">महाराष्ट्र</option>
                                <option value="दिल्ली">दिल्ली</option>
                                <option value="गुजरात">गुजरात</option>
                                <option value="छत्तीसगढ़">छत्तीसगढ़</option>
                                <option value="अन्य">अन्य राज्य</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 text-sm mb-1">पिनकोड <span class="text-rose-600">*</span></label>
                            <input type="text" name="pincode" x-model="formData.pincode" maxlength="6" placeholder="473331" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-4">
                    <button type="button" @click="nextStep(1)" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-bold px-8 py-3 rounded-xl text-base shadow transition">
                        अगला चरण ➔ (सामाजिक जानकारी)
                    </button>
                </div>
            </div>

            <!-- STEP 2: Social & Background Information -->
            <div x-show="step === 2" class="space-y-6">
                <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">चरण 2: व्यक्तिगत एवं सामाजिक पृष्ठभूमि</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">शैक्षणिक योग्यता (Education)</label>
                        <input type="text" name="education" value="{{ old('education') }}" placeholder="उदा. स्नातक / बी.कॉम / बी.टेक" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">व्यवसाय / पेशा (Occupation)</label>
                        <input type="text" name="occupation" value="{{ old('occupation') }}" placeholder="उदा. व्यापार / सर्विस / विद्यार्थी" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">सामाजिक संस्था का नाम</label>
                        <input type="text" name="social_org" value="{{ old('social_org') }}" placeholder="उदा. सकल जैन समाज / जैन युवा मंडल" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">संस्था में पद (Position)</label>
                        <input type="text" name="social_position" value="{{ old('social_position') }}" placeholder="उदा. अध्यक्ष / सचिव / सदस्य" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                    </div>
                </div>

                <div class="p-4 bg-amber-50 rounded-2xl border border-amber-200 space-y-3">
                    <label class="block font-bold text-maroon-900 text-base">क्या आपने पूर्व में संस्कार शिविर में भाग लिया है?</label>
                    <div class="flex items-center gap-6">
                        <label class="inline-flex items-center gap-2 font-medium">
                            <input type="radio" name="previous_shivir_attended" value="1" x-model="hasPrevious" class="w-5 h-5 text-amber-600">
                            <span>हाँ, पूर्व में भाग लिया है</span>
                        </label>
                        <label class="inline-flex items-center gap-2 font-medium">
                            <input type="radio" name="previous_shivir_attended" value="0" x-model="hasPrevious" class="w-5 h-5 text-amber-600">
                            <span>नहीं, यह मेरा पहला शिविर है</span>
                        </label>
                    </div>

                    <div x-show="hasPrevious == '1'" class="pt-2">
                        <label class="block font-bold text-slate-700 text-sm mb-1">पूर्व में भाग लिए गए शिविरों की संख्या</label>
                        <input type="number" name="previous_shivir_count" value="{{ old('previous_shivir_count', 1) }}" min="1" max="30" class="w-48 px-4 py-2.5 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 text-base font-medium">
                    </div>
                </div>

                <div class="flex justify-between pt-4">
                    <button type="button" @click="step = 1" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold px-6 py-3 rounded-xl text-base">
                        ⬅ पिछला चरण
                    </button>
                    <button type="button" @click="nextStep(2)" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-bold px-8 py-3 rounded-xl text-base shadow transition">
                        अगला चरण ➔ (आपात्कालीन संपर्क)
                    </button>
                </div>
            </div>

            <!-- STEP 3: Emergency Information -->
            <div x-show="step === 3" class="space-y-6">
                <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">चरण 3: आपात्कालीन संपर्क जानकारी</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">आपातकालीन संपर्क व्यक्ति का नाम <span class="text-rose-600">*</span></label>
                        <input type="text" name="emergency_contact_name" x-model="formData.emergency_contact_name" placeholder="उदा. परिवार के किसी सदस्य का नाम" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">आपातकालीन मोबाइल नंबर <span class="text-rose-600">*</span></label>
                        <input type="tel" name="emergency_contact_number" x-model="formData.emergency_contact_number" maxlength="10" placeholder="9826099999" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 text-sm mb-1">रक्त समूह (Blood Group)</label>
                        <select name="blood_group" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-base font-medium">
                            <option value="">-- चयन करें (यदि ज्ञात हो) --</option>
                            <option value="A+">A+</option>
                            <option value="A-">A-</option>
                            <option value="B+">B+</option>
                            <option value="B-">B-</option>
                            <option value="O+">O+</option>
                            <option value="O-">O-</option>
                            <option value="AB+">AB+</option>
                            <option value="AB-">AB-</option>
                        </select>
                    </div>
                </div>

                <div class="flex justify-between pt-4">
                    <button type="button" @click="step = 2" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold px-6 py-3 rounded-xl text-base">
                        ⬅ पिछला चरण
                    </button>
                    <button type="button" @click="nextStep(3)" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-bold px-8 py-3 rounded-xl text-base shadow transition">
                        अगला चरण ➔ (दस्तावेज़)
                    </button>
                </div>
            </div>

            <!-- STEP 4: Documents -->
            <div x-show="step === 4" class="space-y-6">
                <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">चरण 4: पासपोर्ट साइज फोटो एवं पहचान पत्र अपलोड करें</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="p-4 bg-slate-50 border-2 border-dashed border-slate-300 rounded-2xl text-center">
                        <label class="block font-bold text-slate-800 text-base mb-2">पासपोर्ट साइज फोटो</label>
                        <input type="file" name="photo" accept="image/*" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-800 hover:file:bg-amber-100">
                        <p class="text-xs text-slate-400 mt-2">JPG, PNG (अधिकतम 2MB)</p>
                    </div>

                    <div class="p-4 bg-slate-50 border-2 border-dashed border-slate-300 rounded-2xl text-center">
                        <label class="block font-bold text-slate-800 text-base mb-2">पहचान पत्र (आधार / वोटर आईडी)</label>
                        <input type="file" name="id_document" accept="image/*,.pdf" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-amber-50 file:text-amber-800 hover:file:bg-amber-100">
                        <p class="text-xs text-slate-400 mt-2">JPG, PNG, PDF (अधिकतम 4MB)</p>
                    </div>
                </div>

                <div class="flex justify-between pt-4">
                    <button type="button" @click="step = 3" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold px-6 py-3 rounded-xl text-base">
                        ⬅ पिछला चरण
                    </button>
                    <button type="button" @click="nextStep(4)" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-bold px-8 py-3 rounded-xl text-base shadow transition">
                        अंतिम चरण ➔ (नियम एवं घोषणा)
                    </button>
                </div>
            </div>

            <!-- STEP 5: Rules & Mandatory Declaration -->
            <div x-show="step === 5" class="space-y-6">
                <h3 class="font-tiro text-2xl font-bold text-maroon-900 border-b pb-2">चरण 5: नियम स्वीकृति एवं अंतिम घोषणा</h3>

                <!-- Complete Official Rules Container -->
                <div class="bg-amber-900 text-amber-50 p-6 rounded-3xl border-2 border-amber-500 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between border-b border-amber-500/50 pb-3">
                        <h4 class="font-tiro font-bold text-amber-200 text-xl sm:text-2xl flex items-center gap-2">
                            📜 <span>शिविर के आवश्यक नियम एवं दिशा-निर्देश (कुल {{ $shivir->rules->count() }} नियम)</span>
                        </h4>
                        <span class="text-xs bg-amber-500 text-maroon-950 font-extrabold px-3 py-1 rounded-full uppercase">पढ़ना अनिवार्य है</span>
                    </div>

                    <div class="max-h-96 overflow-y-auto pr-2 space-y-3">
                        @foreach($shivir->rules as $index => $rule)
                            <div class="bg-maroon-900/90 p-4 rounded-2xl border border-amber-500/40 space-y-1">
                                <h5 class="font-bold text-amber-300 text-base sm:text-lg flex items-center gap-2">
                                    <span>📌</span> <span>{{ $index + 1 }}. {{ $rule->title }}</span>
                                </h5>
                                <p class="text-xs sm:text-sm text-amber-100/95 leading-relaxed pl-6">{!! nl2br(e($rule->rule_text)) !!}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="p-6 bg-amber-50 border-2 border-amber-400 rounded-2xl shadow-md">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" name="rules_accepted" value="1" x-model="formData.rules_accepted" class="w-6 h-6 text-amber-600 rounded border-slate-300 focus:ring-amber-500 mt-0.5">
                        <span class="font-bold text-slate-900 text-base sm:text-lg leading-snug">
                            मैंने संस्कार शिविर के उपरोक्त सभी {{ $shivir->rules->count() }} नियमों एवं निर्देशों को ध्यानपूर्वक पढ़ लिया है तथा मैं उनका पूर्ण निष्ठा से पालन करने के लिए सहमत हूँ। <span class="text-rose-600">*</span>
                        </span>
                    </label>
                </div>

                <div class="flex justify-between items-center pt-4">
                    <button type="button" @click="step = 4" class="bg-slate-200 hover:bg-slate-300 text-slate-800 font-bold px-6 py-3 rounded-xl text-base">
                        ⬅ पिछला चरण
                    </button>

                    <button type="submit" @click="submitForm($event)" class="bg-maroon-800 hover:bg-maroon-900 text-amber-300 font-extrabold text-xl px-10 py-4 rounded-xl shadow-xl transition transform hover:-translate-y-0.5 border-2 border-amber-500 cursor-pointer">
                        🚩 पंजीयन फॉर्म जमा करें (Submit)
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
    function registrationWizard() {
        return {
            step: 1,
            calculatedAge: null,
            hasPrevious: '{{ old('previous_shivir_attended', 0) }}',
            stepError: '',
            formData: {
                full_name: '{{ old('full_name') }}',
                father_name: '{{ old('father_name') }}',
                dob: '{{ old('dob') }}',
                mobile: '{{ old('mobile') }}',
                address: '{{ old('address') }}',
                city: '{{ old('city') }}',
                district: '{{ old('district') }}',
                state: '{{ old('state', 'मध्य प्रदेश') }}',
                pincode: '{{ old('pincode') }}',
                emergency_contact_name: '{{ old('emergency_contact_name') }}',
                emergency_contact_number: '{{ old('emergency_contact_number') }}',
                rules_accepted: true
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
            nextStep(currentStep) {
                this.stepError = '';
                if (currentStep === 1) {
                    if (!this.formData.full_name || !this.formData.father_name || !this.formData.dob || !this.formData.mobile || !this.formData.address || !this.formData.city || !this.formData.district || !this.formData.pincode) {
                        this.stepError = 'कृपया चरण 1 की सभी अनिवार्य जानकारी (नाम, पिता का नाम, जन्मतिथि, मोबाइल, पता, शहर, जिला, पिनकोड) भरें।';
                        return;
                    }
                    if (this.formData.mobile.length < 10) {
                        this.stepError = 'कृपया 10 अंकों का वैध मोबाइल नंबर दर्ज करें।';
                        return;
                    }
                }

                if (currentStep === 3) {
                    if (!this.formData.emergency_contact_name || !this.formData.emergency_contact_number) {
                        this.stepError = 'कृपया आपात्कालीन संपर्क व्यक्ति का नाम तथा मोबाइल नंबर दर्ज करें।';
                        return;
                    }
                }

                this.step = currentStep + 1;
                window.scrollTo({ top: 150, behavior: 'smooth' });
            },
            goToStep(targetStep) {
                this.stepError = '';
                this.step = targetStep;
            },
            submitForm(event) {
                this.stepError = '';
                if (!this.formData.full_name || !this.formData.father_name || !this.formData.mobile || !this.formData.emergency_contact_name || !this.formData.emergency_contact_number) {
                    event.preventDefault();
                    this.stepError = 'कृपया फॉर्म की सभी आवश्यक जानकारी (नाम, पिता का नाम, मोबाइल नंबर, आपात्कालीन संपर्क) पूर्ण करें।';
                    this.step = 1;
                    return false;
                }
                if (!this.formData.rules_accepted) {
                    event.preventDefault();
                    this.stepError = 'शिविर के नियमों एवं घोषणा पत्र को स्वीकार करना अनिवार्य है।';
                    return false;
                }
            }
        }
    }
</script>
@endsection
