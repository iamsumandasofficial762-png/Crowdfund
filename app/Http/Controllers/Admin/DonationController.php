<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\View\View;

class DonationController extends Controller
{
    public function index(): View
    {
        $donations = Donation::with('fundraiserPost')->latest()->paginate(20);
        $totals = Donation::paid()
            ->selectRaw('COALESCE(SUM(amount), 0) as total_amount')
            ->selectRaw('COALESCE(SUM(tip_amount), 0) as tip_amount')
            ->selectRaw('COALESCE(SUM(CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END), 0) as main_amount')
            ->first();
        $totalAmount = (float) $totals->total_amount;
        $tipAmount = (float) $totals->tip_amount;
        $mainAmount = (float) $totals->main_amount;

        return view('admin.donations.index', compact('donations', 'totalAmount', 'mainAmount', 'tipAmount'));
    }
}
