<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FundraiserReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FundraiserReportController extends Controller
{
    public function index(): View
    {
        $supporterReports = FundraiserReport::with('fundraiserPost')->latest()->paginate(20, ['*'], 'supporter_page');
        $statusCounts = [
            FundraiserReport::STATUS_UNDER_PROCESSING => FundraiserReport::where('status', FundraiserReport::STATUS_UNDER_PROCESSING)->count(),
            FundraiserReport::STATUS_SOLVED => FundraiserReport::where('status', FundraiserReport::STATUS_SOLVED)->count(),
            FundraiserReport::STATUS_DISMISSED => FundraiserReport::where('status', FundraiserReport::STATUS_DISMISSED)->count(),
        ];

        return view('admin.fundraiser-reports.index', compact('supporterReports', 'statusCounts'));
    }

    public function updateStatus(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(array_keys(FundraiserReport::statuses()))],
        ]);

        FundraiserReport::findOrFail($id)->update([
            'status' => $validated['status'],
        ]);

        return back()->with('status', 'Report status updated successfully.');
    }
}
