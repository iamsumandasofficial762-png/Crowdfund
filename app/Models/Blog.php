<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class Blog extends Model
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    protected $fillable = [
        'title',
        'slug',
        'blog_category_id',
        'category',
        'tags',
        'short_description',
        'full_description',
        'featured_image',
        'status',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'tags' => 'array',
        ];
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', self::STATUS_PUBLISHED)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function displayDate(): Carbon
    {
        return $this->published_at ?? $this->created_at;
    }

    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        return $query->when($category, function (Builder $query) use ($category) {
            $query->where(function (Builder $query) use ($category) {
                $query->whereHas('blogCategory', fn (Builder $query) => $query->where('slug', $category))
                    ->orWhere('category', $category);
            });
        });
    }

    public function categoryLabel(): string
    {
        $label = $this->blogCategory?->name
            ?? self::categoryOptions()[$this->category]
            ?? Str::headline((string) $this->category);

        return $label !== '' ? $label : 'Stories';
    }

    public function tagList(): array
    {
        return is_array($this->tags) ? $this->tags : [];
    }

    public function tagsForInput(): string
    {
        return implode(', ', $this->tagList());
    }

    public static function categoryOptions(): array
    {
        if (! Schema::hasTable('blog_categories')) {
            return [];
        }

        return BlogCategory::active()
            ->orderBy('name')
            ->pluck('name', 'slug')
            ->all();
    }

    public static function categorySlugs(): array
    {
        return array_keys(self::categoryOptions());
    }

    public static function normalizeTags(?string $tags): array
    {
        return collect(preg_split('/[,\\s]+/', (string) $tags))
            ->map(fn (string $tag) => trim($tag))
            ->filter()
            ->map(function (string $tag) {
                $tag = ltrim($tag, '#');
                $tag = Str::of($tag)->lower()->replaceMatches('/[^a-z0-9_-]+/', '-')->trim('-')->toString();

                return $tag ? '#' . $tag : null;
            })
            ->filter()
            ->unique()
            ->take(20)
            ->values()
            ->all();
    }

    public function imageUrl(): string
    {
        return $this->featured_image
            ? asset('storage/' . $this->featured_image)
            : asset('assets/images/blog/one.png');
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: 'blog';
        $slug = $baseSlug;
        $count = 2;

        while (static::query()
            ->where('slug', $slug)
            ->when($ignoreId, fn (Builder $query) => $query->whereKeyNot($ignoreId))
            ->exists()) {
            $slug = $baseSlug . '-' . $count;
            $count++;
        }

        return $slug;
    }
}
