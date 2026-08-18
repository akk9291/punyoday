<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Shivir;

class ShivirArchiveController extends Controller
{
    public function index()
    {
        $shivirs = Shivir::orderBy('year', 'desc')->get();
        return view('public.archive', compact('shivirs'));
    }
}
