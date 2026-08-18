@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        <h1 class="font-tiro text-2xl font-bold text-slate-900 border-b pb-3">नया वार्षिक संस्कार शिविर जोड़ें</h1>

        <form action="{{ route('admin.shivirs.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 text-sm mb-1">शिविर का नाम (Shivir Name) *</label>
                    <input type="text" name="name" required placeholder="उदा. 34वाँ श्रावक संस्कार शिविर – गुना 2027" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">शिविर संख्या (Shivir Number)</label>
                    <input type="text" name="shivir_number" placeholder="उदा. 34वाँ" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">वर्ष (Year) *</label>
                    <input type="number" name="year" value="2027" required min="2020" max="2040" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">स्थान (Location City) *</label>
                    <input type="text" name="location" required placeholder="गुना (म.प्र.)" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">वेन्यू / परिसर (Venue Address) *</label>
                    <input type="text" name="venue" required placeholder="श्री दिगंबर जैन बड़ा मंदिर परिसर" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">शिविर प्रारंभ तिथि (Start Date) *</label>
                    <input type="date" name="start_date" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">शिविर समापन तिथि (End Date) *</label>
                    <input type="date" name="end_date" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">पंजीयन प्रारंभ तिथि</label>
                    <input type="date" name="reg_start_date" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">पंजीयन अंतिम तिथि</label>
                    <input type="date" name="reg_end_date" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">स्थिति (Status) *</label>
                    <select name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                        <option value="draft">Draft (प्रारूप)</option>
                        <option value="registration_open">Registration Open (पंजीयन चालू)</option>
                        <option value="registration_closed">Registration Closed (पंजीयन बंद)</option>
                        <option value="ongoing">Ongoing (शिविर जारी)</option>
                        <option value="completed">Completed (संपन्न)</option>
                        <option value="archived">Archived (आर्काइव)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">अधिकतम सीमा (Max Limit) *</label>
                    <input type="number" name="max_limit" value="3000" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">पंजीयन आईडी प्रीफिक्स (Reg ID Prefix) *</label>
                    <input type="text" name="prefix" value="GUN-2027-" required class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 text-sm mb-1">विवरण एवं विवरण संदेश (Description)</label>
                <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-300 focus:ring-2 focus:ring-amber-500 font-medium"></textarea>
            </div>

            <div class="flex justify-end gap-3 border-t pt-4">
                <a href="{{ route('admin.shivirs.index') }}" class="bg-slate-200 text-slate-700 font-bold px-6 py-3 rounded-xl">रद्द करें</a>
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold px-8 py-3 rounded-xl shadow">शिविर सहेजें (Save)</button>
            </div>
        </form>
    </div>
</div>
@endsection
