<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FundraiserPost;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminFundraiserPostController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->query('status', 'all');
        $allowedStatuses = [
            'all',
            FundraiserPost::STATUS_PENDING,
            FundraiserPost::STATUS_APPROVED,
            FundraiserPost::STATUS_HOLD,
            FundraiserPost::STATUS_REJECTED,
        ];

        if (! in_array($status, $allowedStatuses, true)) {
            $status = 'all';
        }

        $posts = FundraiserPost::query()
            ->with('fundraiser')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $counts = $this->statusCounts();

        return view('admin.fundraiser-posts.index', compact('posts', 'counts', 'status'));
    }

    public function updateStatus(Request $request, FundraiserPost $post): RedirectResponse|JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(array_keys(FundraiserPost::statuses()))],
            'reason' => [
                Rule::requiredIf(fn () => in_array($request->input('status'), [
                    FundraiserPost::STATUS_HOLD,
                    FundraiserPost::STATUS_REJECTED,
                ], true)),
                'nullable',
                'string',
                'max:5000',
            ],
        ]);

        $targetStatus = $validated['status'];
        $action = $targetStatus === FundraiserPost::STATUS_APPROVED ? FundraiserPost::ACTION_APPROVE : $targetStatus;

        abort_unless($post->canAdminAction($action), 422, 'This action is not available for the current post status.');

        $post->applyModerationStatus($targetStatus, $validated['reason'] ?? null);
        $post->refresh();

        $message = match ($targetStatus) {
            FundraiserPost::STATUS_APPROVED => 'Fundraiser post approved successfully.',
            FundraiserPost::STATUS_HOLD => 'Fundraiser post moved to hold successfully.',
            FundraiserPost::STATUS_REJECTED => 'Fundraiser post rejected successfully.',
            default => 'Fundraiser post status updated successfully.',
        };

        if ($request->expectsJson()) {
            return response()->json([
                'message' => $message,
                'post' => [
                    'id' => $post->id,
                    'status' => $post->status,
                    'status_label' => $post->statusLabel(),
                    'actions' => $post->adminActions(),
                    'hold_reason' => $post->hold_reason,
                    'rejected_reason' => $post->rejected_reason,
                ],
                'counts' => $this->statusCounts(),
            ]);
        }

        return back()->with('status', $message);
    }

    public function approve(Request $request, FundraiserPost $post): RedirectResponse|JsonResponse
    {
        $request->merge(['status' => FundraiserPost::STATUS_APPROVED]);

        return $this->updateStatus($request, $post);
    }

    public function reject(Request $request, FundraiserPost $post): RedirectResponse|JsonResponse
    {
        $request->merge([
            'status' => FundraiserPost::STATUS_REJECTED,
            'reason' => $request->input('reason', $request->input('rejected_reason')),
        ]);

        return $this->updateStatus($request, $post);
    }

    public function hold(Request $request, FundraiserPost $post): RedirectResponse|JsonResponse
    {
        $request->merge([
            'status' => FundraiserPost::STATUS_HOLD,
            'reason' => $request->input('reason', $request->input('hold_reason')),
        ]);

        return $this->updateStatus($request, $post);
    }

    public function destroy(FundraiserPost $post): RedirectResponse
    {
        abort_unless($post->canAdminAction(FundraiserPost::ACTION_DELETE), 422, 'Only rejected fundraiser posts can be deleted from review.');

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

    private function statusCounts(): array
    {
        return [
            'all' => FundraiserPost::count(),
            'pending' => FundraiserPost::pending()->count(),
            'approved' => FundraiserPost::approved()->count(),
            'hold' => FundraiserPost::hold()->count(),
            'rejected' => FundraiserPost::where('status', FundraiserPost::STATUS_REJECTED)->count(),
        ];
    }
}
