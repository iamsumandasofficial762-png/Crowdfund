<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    public function index(): View
    {
        $categories = BlogCategory::withCount('blogs')
            ->latest()
            ->paginate(15);

        return view('admin.blog-categories.index', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ]);

        BlogCategory::create([
            'name' => $validated['name'],
            'slug' => BlogCategory::uniqueSlug($validated['name']),
            'status' => $request->boolean('status', true),
        ]);

        return back()->with('status', 'Blog category created successfully.');
    }

    public function edit(BlogCategory $blogCategory): View
    {
        return view('admin.blog-categories.edit', compact('blogCategory'));
    }

    public function update(Request $request, BlogCategory $blogCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'status' => ['nullable', 'boolean'],
        ]);

        $blogCategory->update([
            'name' => $validated['name'],
            'slug' => BlogCategory::uniqueSlug($validated['name'], $blogCategory->getKey()),
            'status' => $request->boolean('status'),
        ]);

        return redirect()->route('admin.blog-categories.index')->with('status', 'Blog category updated successfully.');
    }

    public function destroy(BlogCategory $blogCategory): RedirectResponse
    {
        $blogCategory->delete();

        return back()->with('status', 'Blog category deleted successfully.');
    }
}
