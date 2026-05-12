<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fundraiser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminFundraiserController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', Fundraiser::STATUS_PENDING);
        $allowedStatuses = [
            Fundraiser::STATUS_PENDING,
            Fundraiser::STATUS_APPROVED,
            Fundraiser::STATUS_REJECTED,
            'all',
        ];

        if (! in_array($status, $allowedStatuses, true)) {
            $status = Fundraiser::STATUS_PENDING;
        }

        $fundraisers = Fundraiser::query()
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $counts = [
            'pending' => Fundraiser::pending()->count(),
            'approved' => Fundraiser::approved()->count(),
            'rejected' => Fundraiser::where('status', Fundraiser::STATUS_REJECTED)->count(),
            'all' => Fundraiser::count(),
        ];

        return view('admin.fundraisers.index', compact('fundraisers', 'counts', 'status'));
    }

    public function approve(Fundraiser $fundraiser): RedirectResponse
    {
        $fundraiser->update([
            'status' => Fundraiser::STATUS_APPROVED,
            'approved_at' => now(),
            'rejected_at' => null,
        ]);

        return back()->with('status', 'Fundraiser profile approved successfully.');
    }

    public function reject(Fundraiser $fundraiser): RedirectResponse
    {
        $fundraiser->update([
            'status' => Fundraiser::STATUS_REJECTED,
            'approved_at' => null,
            'rejected_at' => now(),
        ]);

        return back()->with('status', 'Fundraiser profile rejected successfully.');
    }
}
