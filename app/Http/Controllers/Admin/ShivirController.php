<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shivir;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShivirController extends Controller
{
    public function index()
    {
        $shivirs = Shivir::orderBy('year', 'desc')->get();
        return view('admin.shivirs.index', compact('shivirs'));
    }

    public function create()
    {
        return view('admin.shivirs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'shivir_number' => 'nullable|string|max:50',
            'year' => 'required|integer|min:2020|max:2040',
            'location' => 'required|string|max:100',
            'venue' => 'required|string|max:200',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reg_start_date' => 'nullable|date',
            'reg_end_date' => 'nullable|date|after_or_equal:reg_start_date',
            'status' => 'required|in:draft,registration_open,registration_closed,ongoing,completed,archived',
            'max_limit' => 'required|integer|min:1',
            'prefix' => 'required|string|max:20',
            'contact_info' => 'nullable|string',
            'is_male_only' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name'] . '-' . $validated['year']);
        $validated['is_male_only'] = $request->has('is_male_only');

        Shivir::create($validated);

        return redirect()->route('admin.shivirs.index')->with('success', 'नया शिविर सफलतापूर्वक जोड़ा गया!');
    }

    public function edit(Shivir $shivir)
    {
        return view('admin.shivirs.edit', compact('shivir'));
    }

    public function update(Request $request, Shivir $shivir)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'shivir_number' => 'nullable|string|max:50',
            'year' => 'required|integer|min:2020|max:2040',
            'location' => 'required|string|max:100',
            'venue' => 'required|string|max:200',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reg_start_date' => 'nullable|date',
            'reg_end_date' => 'nullable|date|after_or_equal:reg_start_date',
            'status' => 'required|in:draft,registration_open,registration_closed,ongoing,completed,archived',
            'max_limit' => 'required|integer|min:1',
            'prefix' => 'required|string|max:20',
            'contact_info' => 'nullable|string',
            'is_male_only' => 'nullable|boolean',
            'description' => 'nullable|string',
        ]);

        $validated['is_male_only'] = $request->has('is_male_only');

        $shivir->update($validated);

        return redirect()->route('admin.shivirs.index')->with('success', 'शिविर की जानकारी अद्यतन (Update) कर दी गई है।');
    }
}
