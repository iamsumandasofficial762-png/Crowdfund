<?php

namespace App\Http\Controllers;

use App\Models\FundraiserPost;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function create(Request $request): View
    {
        return view('fundraiser.posts.create', [
            'fundraiser' => $request->attributes->get('fundraiser'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:500'],
            'full_description' => ['required', 'string'],
            'goal_amount' => ['required', 'numeric', 'min:1'],
            'raised_amount' => ['nullable', 'numeric', 'min:0'],
            'category' => ['required', 'string', 'max:100'],
            'beneficiary_name' => ['required', 'string', 'max:255'],
            'beneficiary_phone' => ['required', 'string', 'max:30'],
            'location' => ['required', 'string', 'max:255'],
            'main_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'supporting_file' => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png,webp', 'max:5120'],
        ]);

        $mainImage = $request->file('main_image')->store('fundraiser-posts/images', 'public');
        $supportingFile = $request->file('supporting_file')?->store('fundraiser-posts/supporting-files', 'public');

        FundraiserPost::create([
            'fundraiser_id' => $request->attributes->get('fundraiser')->id,
            'title' => $validated['title'],
            'short_description' => $validated['short_description'],
            'full_description' => $validated['full_description'],
            'goal_amount' => $validated['goal_amount'],
            'raised_amount' => $validated['raised_amount'] ?? 0,
            'category' => $validated['category'],
            'beneficiary_name' => $validated['beneficiary_name'],
            'beneficiary_phone' => $validated['beneficiary_phone'],
            'location' => $validated['location'],
            'main_image' => $mainImage,
            'supporting_file' => $supportingFile,
            'status' => FundraiserPost::STATUS_PENDING,
        ]);

        return back()->with('status', 'Your fundraiser post has been submitted successfully and is pending admin approval.');
    }
}
