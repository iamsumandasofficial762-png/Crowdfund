<?php

namespace App\Http\Controllers;

use App\Models\FundraiserPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FundraiserPostController extends Controller
{
    public function index(): View
    {
        $posts = FundraiserPost::approved()
            ->with('fundraiser')
            ->latest('approved_at')
            ->paginate(9);

        return view('pages.fundraiser-posts.index', compact('posts'));
    }

    public function myPosts(Request $request): View
    {
        $fundraiser = $request->attributes->get('fundraiser');
        $status = $request->query('status', 'all');
        $search = trim((string) $request->query('search', ''));
        $allowedStatuses = [
            'all',
            FundraiserPost::STATUS_PENDING,
            FundraiserPost::STATUS_APPROVED,
            FundraiserPost::STATUS_REJECTED,
        ];

        if (! in_array($status, $allowedStatuses, true)) {
            $status = 'all';
        }

        $posts = $fundraiser->posts()
            ->withSum('paidDonations', 'amount')
            ->withCount('paidDonations')
            ->when($status !== 'all', fn ($query) => $query->where('status', $status))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('beneficiary_name', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(9)
            ->withQueryString();

        $counts = [
            'all' => $fundraiser->posts()->count(),
            'pending' => $fundraiser->posts()->where('status', FundraiserPost::STATUS_PENDING)->count(),
            'approved' => $fundraiser->posts()->where('status', FundraiserPost::STATUS_APPROVED)->count(),
            'rejected' => $fundraiser->posts()->where('status', FundraiserPost::STATUS_REJECTED)->count(),
        ];

        return view('fundraiser.posts.index', compact('fundraiser', 'posts', 'status', 'search', 'counts'));
    }

    public function create(Request $request): View
    {
        return view('fundraiser.posts.create', [
            'fundraiser' => $request->attributes->get('fundraiser'),
            'post' => null,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatePost($request);

        $mainImage = $request->file('main_image')->store('fundraiser-posts/images', 'public');
        $supportingFile = $request->file('supporting_file')?->store('fundraiser-posts/supporting-files', 'public');

        FundraiserPost::create([
            'fundraiser_id' => $request->attributes->get('fundraiser')->id,
            'title' => $validated['title'],
            'short_description' => $validated['short_description'],
            'full_description' => $validated['full_description'],
            'goal_amount' => $validated['goal_amount'],
            'raised_amount' => 0,
            'category' => $validated['category'],
            'beneficiary_name' => $validated['beneficiary_name'],
            'beneficiary_phone' => $validated['beneficiary_phone'],
            'location' => $validated['location'],
            'main_image' => $mainImage,
            'supporting_file' => $supportingFile,
            'status' => FundraiserPost::STATUS_PENDING,
        ]);

        return redirect()
            ->route('fundraiser.posts.index')
            ->with('status', 'Your fundraiser post has been submitted and is waiting for admin approval.');
    }

    public function show(Request $request, FundraiserPost $post): View
    {
        $this->authorizeFundraiserPost($request, $post);

        $post->load('fundraiser');

        $donations = $post->paidDonations()
            ->latest('paid_at')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $raisedFromDonations = (float) $post->paidDonations()->sum('amount');
        $raisedAmount = max((float) $post->raised_amount, $raisedFromDonations);
        $goalAmount = max((float) $post->goal_amount, 1);
        $stats = [
            'raised' => $raisedAmount,
            'goal' => $goalAmount,
            'remaining' => max($goalAmount - $raisedAmount, 0),
            'donors' => $post->paidDonations()->count(),
            'progress' => min(100, (int) round(($raisedAmount / $goalAmount) * 100)),
        ];

        return view('fundraiser.posts.show', compact('post', 'donations', 'stats'));
    }

    public function edit(Request $request, FundraiserPost $post): View
    {
        $this->authorizeFundraiserPost($request, $post);
        abort_unless($post->status === FundraiserPost::STATUS_PENDING, 403);

        return view('fundraiser.posts.edit', [
            'fundraiser' => $request->attributes->get('fundraiser'),
            'post' => $post,
        ]);
    }

    public function update(Request $request, FundraiserPost $post): RedirectResponse
    {
        $this->authorizeFundraiserPost($request, $post);
        abort_unless($post->status === FundraiserPost::STATUS_PENDING, 403);

        $validated = $this->validatePost($request, true);

        $data = [
            'title' => $validated['title'],
            'short_description' => $validated['short_description'],
            'full_description' => $validated['full_description'],
            'goal_amount' => $validated['goal_amount'],
            'category' => $validated['category'],
            'beneficiary_name' => $validated['beneficiary_name'],
            'beneficiary_phone' => $validated['beneficiary_phone'],
            'location' => $validated['location'],
        ];

        if ($request->hasFile('main_image')) {
            $this->deletePublicFile($post->main_image);
            $data['main_image'] = $request->file('main_image')->store('fundraiser-posts/images', 'public');
        }

        if ($request->hasFile('supporting_file')) {
            $this->deletePublicFile($post->supporting_file);
            $data['supporting_file'] = $request->file('supporting_file')->store('fundraiser-posts/supporting-files', 'public');
        }

        $post->update($data);

        return redirect()
            ->route('fundraiser.posts.show', $post)
            ->with('status', 'Your fundraiser post has been updated successfully.');
    }

    public function destroy(Request $request, FundraiserPost $post): RedirectResponse
    {
        $this->authorizeFundraiserPost($request, $post);
        $this->deletePublicFile($post->main_image);
        $this->deletePublicFile($post->supporting_file);
        $post->delete();

        return redirect()
            ->route('fundraiser.posts.index')
            ->with('status', 'Fundraiser post deleted successfully.');
    }

    private function validatePost(Request $request, bool $isUpdate = false): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:500'],
            'full_description' => ['required', 'string'],
            'goal_amount' => ['required', 'numeric', 'min:1'],
            'category' => ['required', 'string', 'max:100'],
            'beneficiary_name' => ['required', 'string', 'max:255'],
            'beneficiary_phone' => ['required', 'string', 'max:30'],
            'location' => ['required', 'string', 'max:255'],
            'main_image' => [$isUpdate ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'supporting_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
        ]);
    }

    private function authorizeFundraiserPost(Request $request, FundraiserPost $post): void
    {
        abort_unless($post->fundraiser_id === $request->attributes->get('fundraiser')->id, 404);
    }

    private function deletePublicFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
