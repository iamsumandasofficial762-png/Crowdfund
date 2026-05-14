<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FundraiserReferral;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FundraiserReferralController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $allowedStatuses = ['all', FundraiserReferral::STATUS_NEW, FundraiserReferral::STATUS_CONTACTED, FundraiserReferral::STATUS_CLOSED];

        if (! in_array($status, $allowedStatuses, true)) {
            $status = 'all';
        }

        $referrals = FundraiserReferral::query()
            ->with('fundraiserPost')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $counts = [
            'all' => FundraiserReferral::count(),
            'new' => FundraiserReferral::where('status', FundraiserReferral::STATUS_NEW)->count(),
            'contacted' => FundraiserReferral::where('status', FundraiserReferral::STATUS_CONTACTED)->count(),
            'closed' => FundraiserReferral::where('status', FundraiserReferral::STATUS_CLOSED)->count(),
        ];

        return view('admin.fundraiser-referrals.index', compact('referrals', 'counts', 'status'));
    }

    public function updateStatus(Request $request, FundraiserReferral $referral): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:new,contacted,closed'],
        ]);

        $referral->update(['status' => $validated['status']]);

        return back()->with('status', 'Referral status updated successfully.');
    }

    public function destroy(FundraiserReferral $referral): RedirectResponse
    {
        $referral->delete();

        return back()->with('status', 'Referral deleted successfully.');
    }
}
