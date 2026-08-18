<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shivir;
use App\Models\ShivirSection;
use App\Models\ShivirSectionItem;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function index(Request $request)
    {
        $shivirId = $request->get('shivir_id');
        $currentShivir = $shivirId 
            ? Shivir::findOrFail($shivirId) 
            : (Shivir::where('status', 'registration_open')->latest('id')->first() ?? Shivir::latest('id')->first());

        $shivirs = Shivir::orderBy('year', 'desc')->get();

        $sections = $currentShivir ? $currentShivir->sections()->with('items')->get() : collect();

        return view('admin.cms.index', compact('currentShivir', 'shivirs', 'sections'));
    }

    public function storeSection(Request $request)
    {
        $validated = $request->validate([
            'shivir_id' => 'required|exists:shivirs,id',
            'title' => 'required|string|max:150',
            'subtitle' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'background' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);

        ShivirSection::create($validated);

        return back()->with('success', 'नया CMS अनुभाग (Section) सफलतापूर्वक जोड़ा गया!');
    }

    public function updateSection(Request $request, ShivirSection $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'subtitle' => 'nullable|string|max:150',
            'description' => 'nullable|string',
            'background' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $section->update($validated);

        return back()->with('success', 'अनुभाग अद्यतन किया गया।');
    }

    public function destroySection(ShivirSection $section)
    {
        $section->delete();
        return back()->with('success', 'अनुभाग हटा दिया गया है।');
    }

    public function storeItem(Request $request)
    {
        $validated = $request->validate([
            'shivir_section_id' => 'required|exists:shivir_sections,id',
            'name' => 'required|string|max:150',
            'designation' => 'nullable|string|max:150',
            'department' => 'nullable|string|max:150',
            'mobile' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
        ]);

        ShivirSectionItem::create($validated);

        return back()->with('success', 'नया व्यक्ति/आइटम जोड़ा गया!');
    }

    public function updateItem(Request $request, ShivirSectionItem $item)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'designation' => 'nullable|string|max:150',
            'department' => 'nullable|string|max:150',
            'mobile' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $item->update($validated);

        return back()->with('success', 'जानकारी अपडेट की गई।');
    }

    public function destroyItem(ShivirSectionItem $item)
    {
        $item->delete();
        return back()->with('success', 'आइटम हटा दिया गया है।');
    }
}
