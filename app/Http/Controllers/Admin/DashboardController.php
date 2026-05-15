<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\Fundraiser;
use App\Models\FundraiserPost;
use App\Models\FundraiserReferral;
use App\Models\FundraiserReport;
use App\Models\SiteReport;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonthStart = now()->startOfMonth();

        $totalDonations = Donation::paid()
            ->where('created_at', '>=', $currentMonthStart)
            ->get(['main_amount', 'tip_amount', 'amount'])
            ->sum(fn (Donation $donation) => $this->mainDonationAmount($donation));
        $totalTips = (float) Donation::paid()
            ->where('created_at', '>=', $currentMonthStart)
            ->sum('tip_amount');
        $supporterCount = Donation::paid()->count();
        $campaignCount = FundraiserPost::count();
        $liveCampaignCount = FundraiserPost::approved()->count();
        $pendingCampaignCount = FundraiserPost::pending()->count();
        $fundraiserCount = Fundraiser::count();
        $supporterReportCount = FundraiserReport::count();
        $siteReportCount = SiteReport::count();
        $reportCount = $supporterReportCount + $siteReportCount;
        $contactCount = ContactMessage::count();
        $referralCount = FundraiserReferral::count();
        $completedDonationCount = Donation::paid()->count();
        $allDonationCount = Donation::count();
        $successRate = $allDonationCount > 0 ? (int) round(($completedDonationCount / $allDonationCount) * 100) : 0;

        $monthStarts = collect(range(7, 0))->map(fn (int $offset) => now()->startOfMonth()->subMonths($offset));
        $monthlyDonations = Donation::paid()
            ->where('created_at', '>=', $monthStarts->first()->copy()->startOfMonth())
            ->get(['main_amount', 'tip_amount', 'amount', 'created_at'])
            ->groupBy(fn (Donation $donation) => $donation->created_at->format('Y-m'));

        $monthlyChart = $monthStarts->map(function (Carbon $month) use ($monthlyDonations) {
            $donations = $monthlyDonations->get($month->format('Y-m'), collect());
            $donationAmount = $donations->sum(fn (Donation $donation) => $this->mainDonationAmount($donation));
            $tipAmount = $donations->sum(fn (Donation $donation) => (float) $donation->tip_amount);
            $combinedAmount = $donationAmount + $tipAmount;

            return [
                'label' => $month->format('M'),
                'donation' => $donationAmount,
                'tip' => $tipAmount,
                'both' => $combinedAmount,
            ];
        });

        $monthlyChartMax = max((float) $monthlyChart->max('both'), 1);

        $recentDonations = Donation::with('fundraiserPost')->latest()->take(6)->get();
        $recentReports = FundraiserReport::with('fundraiserPost')->latest()->take(5)->get();
        $recentSiteReports = SiteReport::latest()->take(5)->get();
        $recentContacts = ContactMessage::latest()->take(5)->get();
        $recentReferrals = FundraiserReferral::with('fundraiserPost')->latest()->take(5)->get();
        $recentCampaigns = FundraiserPost::latest()->take(5)->get();

        $recentActivity = $this->recentActivity(
            $recentDonations,
            $recentReports,
            $recentSiteReports,
            $recentContacts,
            $recentReferrals,
            $recentCampaigns
        );

        return view('admin.dashboard', compact(
            'totalDonations',
            'totalTips',
            'supporterCount',
            'campaignCount',
            'liveCampaignCount',
            'pendingCampaignCount',
            'fundraiserCount',
            'reportCount',
            'supporterReportCount',
            'siteReportCount',
            'contactCount',
            'referralCount',
            'successRate',
            'monthlyChart',
            'monthlyChartMax',
            'recentActivity',
            'recentDonations',
            'recentReports',
            'recentSiteReports',
            'recentContacts',
            'recentReferrals',
            'recentCampaigns'
        ));
    }

    private function mainDonationAmount(Donation $donation): float
    {
        $mainAmount = (float) $donation->main_amount;

        if ($mainAmount > 0) {
            return $mainAmount;
        }

        return max((float) $donation->amount - (float) $donation->tip_amount, 0);
    }

    private function recentActivity(
        Collection $donations,
        Collection $reports,
        Collection $siteReports,
        Collection $contacts,
        Collection $referrals,
        Collection $campaigns
    ): Collection {
        return collect()
            ->merge($donations->map(fn (Donation $donation) => [
                'activity' => 'Donation received from '.$donation->publicDonorName(),
                'status' => ucfirst($donation->status),
                'time' => $donation->created_at,
            ]))
            ->merge($reports->map(fn (FundraiserReport $report) => [
                'activity' => 'Supporter report submitted',
                'status' => 'Supporter report',
                'time' => $report->created_at,
            ]))
            ->merge($siteReports->map(fn (SiteReport $report) => [
                'activity' => 'Site report submitted'.($report->subject ? ': '.$report->subject : ''),
                'status' => 'Site report',
                'time' => $report->created_at,
            ]))
            ->merge($contacts->map(fn (ContactMessage $message) => [
                'activity' => 'Contact message from '.$message->name,
                'status' => 'Message',
                'time' => $message->created_at,
            ]))
            ->merge($referrals->map(fn (FundraiserReferral $referral) => [
                'activity' => 'Referral request from '.$referral->name,
                'status' => ucfirst($referral->status),
                'time' => $referral->created_at,
            ]))
            ->merge($campaigns->map(fn (FundraiserPost $post) => [
                'activity' => 'Campaign '.$post->status.': '.$post->title,
                'status' => ucfirst($post->status),
                'time' => $post->created_at,
            ]))
            ->sortByDesc('time')
            ->take(8)
            ->values();
    }
}
