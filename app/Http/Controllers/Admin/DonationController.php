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
        $paidDonations = Donation::paid()->get(['amount', 'main_amount', 'tip_amount']);
        $totalAmount = $paidDonations->sum(fn (Donation $donation) => (float) $donation->amount);
        $tipAmount = $paidDonations->sum(fn (Donation $donation) => (float) $donation->tip_amount);
        $mainAmount = $paidDonations->sum(function (Donation $donation) {
            $mainAmount = (float) $donation->main_amount;

            return $mainAmount > 0 ? $mainAmount : max((float) $donation->amount - (float) $donation->tip_amount, 0);
        });

        return view('admin.donations.index', compact('donations', 'totalAmount', 'mainAmount', 'tipAmount'));
    }
}
