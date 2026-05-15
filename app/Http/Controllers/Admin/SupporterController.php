<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\View\View;

class SupporterController extends Controller
{
    public function index(): View
    {
        $supporters = Donation::paid()->with('fundraiserPost')->latest()->paginate(20);

        return view('admin.supporters.index', compact('supporters'));
    }
}
