<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FundraiserReport;
use App\Models\SiteReport;
use Illuminate\View\View;

class FundraiserReportController extends Controller
{
    public function index(): View
    {
        $supporterReports = FundraiserReport::with('fundraiserPost')->latest()->paginate(20, ['*'], 'supporter_page');
        $siteReports = SiteReport::latest()->paginate(20, ['*'], 'site_page');

        return view('admin.fundraiser-reports.index', compact('supporterReports', 'siteReports'));
    }
}
