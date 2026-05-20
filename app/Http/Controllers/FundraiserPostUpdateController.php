<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\FundraiserPost;
use App\Models\FundraiserPostUpdate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class FundraiserPostUpdateController extends Controller
{
    public function campaigns(Request $request): View|RedirectResponse
    {
        $fundraiser = $request->attributes->get('fundraiser');
        if ($redirect = $this->ensureCanManagePosts($request)) {
            return $redirect;
        }

        $posts = $fundraiser->posts()
            ->addSelect([
                'paid_donations_main_sum_amount' => Donation::query()
                    ->selectRaw('COALESCE(SUM(CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END), 0)')
                    ->whereColumn('donations.fundraiser_post_id', 'fundraiser_posts.id')
                    ->where('status', Donation::STATUS_PAID),
            ])
            ->withCount(['updates', 'publishedUpdates'])
            ->withCount('paidDonations')
            ->latest()
            ->paginate(9);

        return view('fundraiser.updates.campaigns', compact('fundraiser', 'posts'));
    }

    public function index(Request $request, FundraiserPost $post): View|RedirectResponse
    {
        $this->authorizeFundraiserPost($request, $post);
        if ($redirect = $this->ensureCanManagePosts($request)) {
            return $redirect;
        }
        if ($redirect = $this->ensureApprovedPostCanBeManaged($post)) {
            return $redirect;
        }

        $post->load('fundraiser')
            ->loadCount('paidDonations');

        $updates = $post->updates()
            ->orderByDesc('is_pinned')
            ->latest()
            ->paginate(10);

        $raisedFromDonations = (float) $post->paidDonations()
            ->selectRaw('COALESCE(SUM(CASE WHEN main_amount > 0 THEN main_amount WHEN amount > tip_amount THEN amount - tip_amount ELSE 0 END), 0) as total')
            ->value('total');
        $raisedAmount = max((float) $post->raised_amount, $raisedFromDonations);

        return view('fundraiser.updates.index', compact('post', 'updates', 'raisedAmount'));
    }

    public function create(Request $request, FundraiserPost $post): RedirectResponse
    {
        $this->authorizeFundraiserPost($request, $post);
        if ($redirect = $this->ensureCanManagePosts($request)) {
            return $redirect;
        }
        if ($redirect = $this->ensureApprovedPostCanBeManaged($post)) {
            return $redirect;
        }

        return redirect()->route('fundraiser.posts.updates.index', $post);
    }

    public function store(Request $request, FundraiserPost $post): RedirectResponse
    {
        $this->authorizeFundraiserPost($request, $post);
        if ($redirect = $this->ensureCanManagePosts($request)) {
            return $redirect;
        }
        if ($redirect = $this->ensureApprovedPostCanBeManaged($post)) {
            return $redirect;
        }

        $validated = $this->validateUpdate($request);
        $imagePath = $request->file('update_image')?->store('fundraiser-updates', 'public');

        $update = $post->updates()->create([
            'title' => $validated['title'] ?? null,
            'update_text' => $validated['update_text'],
            'update_image' => $imagePath,
            'is_published' => true,
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        if ($update->is_pinned) {
            $post->updates()->whereKeyNot($update->id)->update(['is_pinned' => false]);
        }

        return redirect()
            ->route('fundraiser.posts.updates.index', $post)
            ->with('status', 'Story update published successfully.');
    }

    public function edit(Request $request, FundraiserPost $post, FundraiserPostUpdate $update): View|RedirectResponse
    {
        $this->authorizeFundraiserPost($request, $post);
        if ($redirect = $this->ensureCanManagePosts($request)) {
            return $redirect;
        }
        if ($redirect = $this->ensureApprovedPostCanBeManaged($post)) {
            return $redirect;
        }
        $this->authorizeUpdate($post, $update);

        return view('fundraiser.updates.edit', compact('post', 'update'));
    }

    public function update(Request $request, FundraiserPost $post, FundraiserPostUpdate $update): RedirectResponse
    {
        $this->authorizeFundraiserPost($request, $post);
        if ($redirect = $this->ensureCanManagePosts($request)) {
            return $redirect;
        }
        if ($redirect = $this->ensureApprovedPostCanBeManaged($post)) {
            return $redirect;
        }
        $this->authorizeUpdate($post, $update);

        $validated = $this->validateUpdate($request, true);
        $data = [
            'title' => $validated['title'] ?? null,
            'update_text' => $validated['update_text'],
            'is_published' => $request->boolean('is_published', true),
            'is_pinned' => $request->boolean('is_pinned'),
        ];

        if ($request->hasFile('update_image')) {
            $this->deletePublicFile($update->update_image);
            $data['update_image'] = $request->file('update_image')->store('fundraiser-updates', 'public');
        }

        $update->update($data);

        if ($update->is_pinned) {
            $post->updates()->whereKeyNot($update->id)->update(['is_pinned' => false]);
        }

        return redirect()
            ->route('fundraiser.posts.updates.index', $post)
            ->with('status', 'Story update saved successfully.');
    }

    public function destroy(Request $request, FundraiserPost $post, FundraiserPostUpdate $update): RedirectResponse
    {
        $this->authorizeFundraiserPost($request, $post);
        if ($redirect = $this->ensureCanManagePosts($request)) {
            return $redirect;
        }
        if ($redirect = $this->ensureApprovedPostCanBeManaged($post)) {
            return $redirect;
        }
        $this->authorizeUpdate($post, $update);

        $this->deletePublicFile($update->update_image);
        $update->delete();

        return redirect()
            ->route('fundraiser.posts.updates.index', $post)
            ->with('status', 'Story update deleted successfully.');
    }

    private function validateUpdate(Request $request, bool $isUpdate = false): array
    {
        return $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'update_text' => ['required', 'string', 'max:10000'],
            'update_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_published' => [$isUpdate ? 'sometimes' : 'nullable', 'boolean'],
            'is_pinned' => ['nullable', 'boolean'],
        ]);
    }

    private function authorizeFundraiserPost(Request $request, FundraiserPost $post): void
    {
        abort_unless($post->fundraiser_id === $request->attributes->get('fundraiser')->id, 404);
    }

    private function ensureCanManagePosts(Request $request): ?RedirectResponse
    {
        $fundraiser = $request->attributes->get('fundraiser');

        if (! $fundraiser || $fundraiser->canManagePosts()) {
            return null;
        }

        return $this->restrictedAccessRedirect();
    }

    private function ensureApprovedPostCanBeManaged(FundraiserPost $post): ?RedirectResponse
    {
        if ($post->status === FundraiserPost::STATUS_APPROVED) {
            return null;
        }

        return redirect()
            ->route('fundraiser.posts.index')
            ->with('error', 'You can only manage approved posts.');
    }

    private function restrictedAccessRedirect(): RedirectResponse
    {
        return redirect()
            ->route('fundraiser.posts.index')
            ->with('error', 'Your account is currently restricted. You can only view or delete posts.');
    }

    private function authorizeUpdate(FundraiserPost $post, FundraiserPostUpdate $update): void
    {
        abort_unless($update->fundraiser_post_id === $post->id, 404);
    }

    private function deletePublicFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
