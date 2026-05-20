<?php

namespace App\Models;

use App\Support\PublicSiteCache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Event extends Model
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';

    public const CATEGORY_CHILD_TROUBLE_CARE = 'child-trouble-care';
    public const CATEGORY_HEALTH_CARE_PROGRAM = 'health-care-program';
    public const CATEGORY_TRANSPORT_FOOD_PROGRAM = 'transport-food-program';
    public const CATEGORY_EDUCATION_SAFETY_PROGRAM = 'education-safety-program';

    protected $fillable = [
        'title',
        'slug',
        'category',
        'short_description',
        'full_description',
        'event_image',
        'event_date',
        'event_time',
        'location',
        'organizer_name',
        'contact_email',
        'contact_phone',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'event_time' => 'datetime:H:i',
        ];
    }

    protected static function booted(): void
    {
        static::saved(fn () => PublicSiteCache::forgetPublicContent());
        static::deleted(fn () => PublicSiteCache::forgetPublicContent());
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', self::STATUS_PUBLISHED);
    }

    public function scopeUpcoming(Builder $query): Builder
    {
        return $query->where(function (Builder $query) {
            $query->whereNull('event_date')->orWhereDate('event_date', '>=', now()->toDateString());
        });
    }

    public function scopeCategory(Builder $query, ?string $category): Builder
    {
        return $query->when($category, fn (Builder $query) => $query->where('category', $category));
    }

    public function categoryLabel(): string
    {
        return self::categoryOptions()[$this->category] ?? 'General Event';
    }

    public static function categoryOptions(): array
    {
        return [
            self::CATEGORY_CHILD_TROUBLE_CARE => 'Child Trouble & Care',
            self::CATEGORY_HEALTH_CARE_PROGRAM => 'Health Care Program',
            self::CATEGORY_TRANSPORT_FOOD_PROGRAM => 'Transport & Food Program',
            self::CATEGORY_EDUCATION_SAFETY_PROGRAM => 'Education & Safety Program',
        ];
    }

    public static function categorySlugs(): array
    {
        return array_keys(self::categoryOptions());
    }

    public static function categoryCards(): array
    {
        return [
            self::CATEGORY_CHILD_TROUBLE_CARE => [
                'title' => self::categoryOptions()[self::CATEGORY_CHILD_TROUBLE_CARE],
                'label' => 'Child Care',
                'image' => asset('assets/images/event/one.png'),
            ],
            self::CATEGORY_HEALTH_CARE_PROGRAM => [
                'title' => self::categoryOptions()[self::CATEGORY_HEALTH_CARE_PROGRAM],
                'label' => 'Health Support',
                'image' => asset('assets/images/event/two.png'),
            ],
            self::CATEGORY_TRANSPORT_FOOD_PROGRAM => [
                'title' => self::categoryOptions()[self::CATEGORY_TRANSPORT_FOOD_PROGRAM],
                'label' => 'Transport & Food',
                'image' => asset('assets/images/event/three.png'),
            ],
            self::CATEGORY_EDUCATION_SAFETY_PROGRAM => [
                'title' => self::categoryOptions()[self::CATEGORY_EDUCATION_SAFETY_PROGRAM],
                'label' => 'Education & Safety',
                'image' => asset('assets/images/event/poster.png'),
            ],
        ];
    }

    public function imageUrl(): string
    {
        return $this->event_image
            ? asset('storage/' . $this->event_image)
            : asset('assets/images/event/one.png');
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($title) ?: 'event';
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
