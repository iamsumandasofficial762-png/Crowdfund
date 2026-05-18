<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FundraiserPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminFundraiserPostController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', FundraiserPost::STATUS_PENDING);
        $allowedStatuses = [
            FundraiserPost::STATUS_PENDING,
            FundraiserPost::STATUS_APPROVED,
            FundraiserPost::STATUS_REJECTED,
            FundraiserPost::STATUS_HOLD,
            'all',
        ];

        if (! in_array($status, $allowedStatuses, true)) {
            $status = FundraiserPost::STATUS_PENDING;
        }

        $posts = FundraiserPost::query()
            ->with('fundraiser')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $counts = [
            'pending' => FundraiserPost::pending()->count(),
            'approved' => FundraiserPost::approved()->count(),
            'rejected' => FundraiserPost::where('status', FundraiserPost::STATUS_REJECTED)->count(),
            'hold' => FundraiserPost::hold()->count(),
            'all' => FundraiserPost::count(),
        ];

        return view('admin.fundraiser-posts.index', compact('posts', 'counts', 'status'));
    }

    public function approve(FundraiserPost $post): RedirectResponse
    {
        $post->update([
            'status' => FundraiserPost::STATUS_APPROVED,
            'approved_at' => now(),
            'rejected_at' => null,
        ]);

        return back()->with('status', 'Fundraiser post approved successfully.');
    }

    public function reject(FundraiserPost $post): RedirectResponse
    {
        $post->update([
            'status' => FundraiserPost::STATUS_REJECTED,
            'approved_at' => null,
            'rejected_at' => now(),
        ]);

        return back()->with('status', 'Fundraiser post rejected successfully.');
    }

    public function hold(FundraiserPost $post): RedirectResponse
    {
        $post->update([
            'status' => FundraiserPost::STATUS_HOLD,
            'approved_at' => null,
            'rejected_at' => null,
        ]);

        return back()->with('status', 'Fundraiser post moved to hold successfully.');
    }

    public function destroy(FundraiserPost $post): RedirectResponse
    {
        $this->deletePublicFile($post->main_image);
        $this->deletePublicFile($post->supporting_file);
        $post->delete();

        return back()->with('status', 'Fundraiser post deleted successfully.');
    }

    private function deletePublicFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
