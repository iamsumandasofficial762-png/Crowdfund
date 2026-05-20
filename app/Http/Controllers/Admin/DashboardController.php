<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Donation;
use App\Models\Blog;
use App\Models\Event;
use App\Models\Fundraiser;
use App\Models\FundraiserPost;
use App\Models\FundraiserReferral;
use App\Models\FundraiserReport;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $currentMonthStart = now()->startOfMonth();

        $totalDonations = Donation::paid()
            ->where('created_at', '>=', $currentMonthStart)
            ->selectRaw('COALESCE(SUM(CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END), 0) as total')
            ->value('total');
        $totalTips = (float) Donation::paid()
            ->where('created_at', '>=', $currentMonthStart)
            ->sum('tip_amount');
        $supporterCount = Donation::paid()->count();
        $campaignCount = FundraiserPost::count();
        $liveCampaignCount = FundraiserPost::approved()->count();
        $pendingCampaignCount = FundraiserPost::pending()->count();
        $publishedEventCount = Event::where('status', Event::STATUS_PUBLISHED)->count();
        $draftEventCount = Event::where('status', Event::STATUS_DRAFT)->count();
        $publishedBlogCount = Blog::where('status', Blog::STATUS_PUBLISHED)->count();
        $draftBlogCount = Blog::where('status', Blog::STATUS_DRAFT)->count();
        $fundraiserCount = Fundraiser::count();
        $supporterReportCount = FundraiserReport::count();
        $reportCount = $supporterReportCount;
        $contactCount = ContactMessage::count();
        $referralCount = FundraiserReferral::count();
        $completedDonationCount = Donation::paid()->count();
        $allDonationCount = Donation::count();
        $successRate = $allDonationCount > 0 ? (int) round(($completedDonationCount / $allDonationCount) * 100) : 0;

        $monthStarts = collect(range(7, 0))->map(fn (int $offset) => now()->startOfMonth()->subMonths($offset));
        $monthExpression = in_array(DB::connection()->getDriverName(), ['mysql', 'mariadb'], true)
            ? "DATE_FORMAT(created_at, '%Y-%m')"
            : "strftime('%Y-%m', created_at)";
        $monthlyDonations = Donation::paid()
            ->where('created_at', '>=', $monthStarts->first()->copy()->startOfMonth())
            ->selectRaw("{$monthExpression} as donation_month")
            ->selectRaw('COALESCE(SUM(CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END), 0) as donation_amount')
            ->selectRaw('COALESCE(SUM(tip_amount), 0) as tip_amount')
            ->groupBy('donation_month')
            ->get()
            ->keyBy('donation_month');

        $monthlyChart = $monthStarts->map(function (Carbon $month) use ($monthlyDonations) {
            $donations = $monthlyDonations->get($month->format('Y-m'));
            $donationAmount = (float) ($donations->donation_amount ?? 0);
            $tipAmount = (float) ($donations->tip_amount ?? 0);
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
        $recentContacts = ContactMessage::latest()->take(5)->get();
        $recentReferrals = FundraiserReferral::with('fundraiserPost')->latest()->take(5)->get();
        $recentCampaigns = FundraiserPost::latest()->take(5)->get();
        $recentBlogs = Blog::latest()->take(5)->get();
        $recentEvents = Event::latest()->take(5)->get();
        $recentFundraisers = Fundraiser::latest()->take(5)->get();

        $recentActivity = $this->recentActivity(
            $recentDonations,
            $recentReports,
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
            'publishedEventCount',
            'draftEventCount',
            'publishedBlogCount',
            'draftBlogCount',
            'fundraiserCount',
            'reportCount',
            'supporterReportCount',
            'contactCount',
            'referralCount',
            'successRate',
            'monthlyChart',
            'monthlyChartMax',
            'recentActivity',
            'recentDonations',
            'recentReports',
            'recentContacts',
            'recentReferrals',
            'recentCampaigns',
            'recentBlogs',
            'recentEvents',
            'recentFundraisers'
        ));
    }

    private function recentActivity(
        Collection $donations,
        Collection $reports,
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
