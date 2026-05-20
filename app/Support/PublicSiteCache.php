<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class PublicSiteCache
{
    public const HOME_POSTS = 'public.home.recent_fundraiser_posts';
    public const HOME_BLOGS = 'public.home.latest_blogs';
    public const FOOTER_POSTS = 'public.footer.recent_fundraiser_posts';
    public const BLOG_CATEGORY_OPTIONS = 'public.blog.category_options';
    public const BLOG_CATEGORY_COUNTS = 'public.blog.category_counts';
    public const BLOG_POPULAR_TAGS = 'public.blog.popular_tags';
    public const EVENT_CATEGORY_COUNTS = 'public.event.category_counts';
    public const EVENT_RECENT_FUNDRAISERS = 'public.event.recent_fundraiser_posts';

    public static function seconds(): int
    {
        return 600;
    }

    public static function forgetPublicContent(): void
    {
        foreach (self::keys() as $key) {
            Cache::forget($key);
        }
    }

    private static function keys(): array
    {
        return [
            self::HOME_POSTS,
            self::HOME_BLOGS,
            self::FOOTER_POSTS,
            self::BLOG_CATEGORY_OPTIONS,
            self::BLOG_CATEGORY_COUNTS,
            self::BLOG_POPULAR_TAGS,
            self::EVENT_CATEGORY_COUNTS,
            self::EVENT_RECENT_FUNDRAISERS,
        ];
    }
}
