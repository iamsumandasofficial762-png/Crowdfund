<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\FundraiserPost;
use App\Models\FundraiserReport;
use Illuminate\View\View;

class SettingsController extends Controller
{
    public function index(): View
    {
        $settingsSummary = [
            'paid_donations' => Donation::paid()->count(),
            'campaigns' => FundraiserPost::count(),
            'contact_messages' => ContactMessage::count(),
            'supporter_reports' => FundraiserReport::count(),
        ];

        return view('admin.settings.index', compact('settingsSummary'));
    }
}
