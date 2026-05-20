<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Support\UploadedImageOptimizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $blogs = Blog::query()
            ->with('blogCategory')
            ->when(
                in_array($status, [Blog::STATUS_PUBLISHED, Blog::STATUS_DRAFT], true),
                fn ($query) => $query->where('status', $status)
            )
            ->latest('published_at')
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blogs.create', [
            'blog' => new Blog(),
            'categories' => BlogCategory::active()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validatedData($request);
        $data['slug'] = Blog::uniqueSlug($data['title']);
        $data['published_at'] = $this->publishedAt($data);
        $data['tags'] = Blog::normalizeTags($data['tags'] ?? null);
        $data['category'] = BlogCategory::find($data['blog_category_id'])?->slug;

        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
            UploadedImageOptimizer::optimizePublicImage($data['featured_image']);
        }

        $blog = Blog::create($data);

        AdminActivity::create([
            'title' => 'New Blog Created',
            'message' => $blog->title.' was created in the admin panel.',
            'type' => 'blog',
            'created_by' => auth()->user()->name ?? 'Admin',
        ]);

        return redirect()->route('admin.blogs.index')->with('status', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', [
            'blog' => $blog,
            'categories' => $this->categoriesForForm($blog),
        ]);
    }

    public function update(Request $request, Blog $blog)
    {
        $data = $this->validatedData($request, $blog);
        $data['slug'] = Blog::uniqueSlug($data['title'], $blog->getKey());
        $data['published_at'] = $this->publishedAt($data);
        $data['tags'] = Blog::normalizeTags($data['tags'] ?? null);
        $data['category'] = BlogCategory::find($data['blog_category_id'])?->slug;

        if ($request->hasFile('featured_image')) {
            if ($blog->featured_image) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $data['featured_image'] = $request->file('featured_image')->store('blogs', 'public');
            UploadedImageOptimizer::optimizePublicImage($data['featured_image']);
        }

        $blog->update($data);

        return redirect()->route('admin.blogs.index')->with('status', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->featured_image) {
            Storage::disk('public')->delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('admin.blogs.index')->with('status', 'Blog deleted successfully.');
    }

    private function validatedData(Request $request, ?Blog $blog = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'blog_category_id' => [
                'required',
                Rule::exists('blog_categories', 'id')->where(function ($query) use ($blog) {
                    $query->where('status', true)
                        ->when($blog?->blog_category_id, fn ($query, $categoryId) => $query->orWhere('id', $categoryId));
                }),
            ],
            'tags' => ['nullable', 'string', 'max:1000'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'full_description' => ['required', 'string'],
            'featured_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'status' => ['required', Rule::in([Blog::STATUS_DRAFT, Blog::STATUS_PUBLISHED])],
            'published_at' => ['nullable', 'date'],
        ]);
    }

    private function publishedAt(array $data): mixed
    {
        if ($data['status'] === Blog::STATUS_PUBLISHED) {
            return $data['published_at'] ?: now();
        }

        return $data['published_at'] ?: null;
    }

    private function categoriesForForm(?Blog $blog = null)
    {
        return BlogCategory::query()
            ->where(function ($query) use ($blog) {
                $query->where('status', true)
                    ->when($blog?->blog_category_id, fn ($query, $categoryId) => $query->orWhere('id', $categoryId));
            })
            ->orderBy('name')
            ->get();
    }
}
