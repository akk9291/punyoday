@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-slate-200 shadow-sm space-y-6">
        <h1 class="font-tiro text-2xl font-bold text-slate-900 border-b pb-3">शिविर विवरण अद्यतन (Edit Shivir)</h1>

        <form action="{{ route('admin.shivirs.update', $shivir->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="block font-bold text-slate-700 text-sm mb-1">शिविर का नाम *</label>
                    <input type="text" name="name" value="{{ old('name', $shivir->name) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">शिविर संख्या</label>
                    <input type="text" name="shivir_number" value="{{ old('shivir_number', $shivir->shivir_number) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">वर्ष *</label>
                    <input type="number" name="year" value="{{ old('year', $shivir->year) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">स्थान *</label>
                    <input type="text" name="location" value="{{ old('location', $shivir->location) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">वेन्यू *</label>
                    <input type="text" name="venue" value="{{ old('venue', $shivir->venue) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">शिविर प्रारंभ तिथि *</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $shivir->start_date->format('Y-m-d')) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">शिविर समापन तिथि *</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $shivir->end_date->format('Y-m-d')) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">स्थिति (Status) *</label>
                    <select name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium">
                        <option value="draft" {{ $shivir->status === 'draft' ? 'selected' : '' }}>Draft (प्रारूप)</option>
                        <option value="registration_open" {{ $shivir->status === 'registration_open' ? 'selected' : '' }}>Registration Open (पंजीयन चालू)</option>
                        <option value="registration_closed" {{ $shivir->status === 'registration_closed' ? 'selected' : '' }}>Registration Closed (पंजीयन बंद)</option>
                        <option value="ongoing" {{ $shivir->status === 'ongoing' ? 'selected' : '' }}>Ongoing (शिविर जारी)</option>
                        <option value="completed" {{ $shivir->status === 'completed' ? 'selected' : '' }}>Completed (संपन्न)</option>
                        <option value="archived" {{ $shivir->status === 'archived' ? 'selected' : '' }}>Archived (आर्काइव)</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">अधिकतम सीमा *</label>
                    <input type="number" name="max_limit" value="{{ old('max_limit', $shivir->max_limit) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium">
                </div>

                <div>
                    <label class="block font-bold text-slate-700 text-sm mb-1">पंजीयन आईडी प्रीफिक्स *</label>
                    <input type="text" name="prefix" value="{{ old('prefix', $shivir->prefix) }}" required class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium">
                </div>
            </div>

            <div>
                <label class="block font-bold text-slate-700 text-sm mb-1">संपर्क हेल्प लाइन जानकारी</label>
                <input type="text" name="contact_info" value="{{ old('contact_info', $shivir->contact_info) }}" class="w-full px-4 py-3 rounded-xl border border-slate-300 font-medium">
            </div>

            <div class="flex justify-end gap-3 border-t pt-4">
                <a href="{{ route('admin.shivirs.index') }}" class="bg-slate-200 text-slate-700 font-bold px-6 py-3 rounded-xl">रद्द करें</a>
                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-maroon-900 font-extrabold px-8 py-3 rounded-xl shadow">अद्यतन करें (Update)</button>
            </div>
        </form>
    </div>
</div>
@endsection
