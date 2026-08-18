<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Shivir;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(?string $slug = null)
    {
        if ($slug) {
            $shivir = Shivir::where('slug', $slug)->firstOrFail();
        } else {
            // Get current active shivir (or latest created)
            $shivir = Shivir::whereIn('status', ['registration_open', 'ongoing', 'draft'])
                ->latest('id')
                ->first();

            if (!$shivir) {
                $shivir = Shivir::latest('id')->firstOrFail();
            }
        }

        $shivir->load([
            'sections' => function ($q) {
                $q->where('is_active', true)->with('activeItems');
            },
            'rules' => function ($q) {
                $q->where('is_active', true);
            },
            'faqs' => function ($q) {
                $q->where('is_active', true);
            },
            'schedules' => function ($q) {
                $q->where('is_active', true);
            },
            'announcements' => function ($q) {
                $q->where('is_active', true);
            },
        ]);

        return view('public.home', compact('shivir'));
    }
}
