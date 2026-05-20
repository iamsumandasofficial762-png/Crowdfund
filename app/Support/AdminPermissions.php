<?php

namespace App\Support;

class AdminPermissions
{
    public const DASHBOARD_VIEW = 'dashboard.view';
    public const FUNDRAISER_POSTS_MANAGE = 'fundraiser_posts.manage';
    public const FUNDRAISER_POSTS_MODERATE = 'fundraiser_posts.moderate';
    public const DONATIONS_MANAGE = 'donations.manage';
    public const BLOGS_MANAGE = 'blogs.manage';
    public const EVENTS_MANAGE = 'events.manage';
    public const REPORTS_MANAGE = 'reports.manage';
    public const CATEGORIES_MANAGE = 'categories.manage';
    public const NOTIFICATIONS_MANAGE = 'notifications.manage';
    public const USERS_MANAGE = 'manage_users';
    public const RECORDS_DELETE = 'records.delete';
    public const FUNDRAISERS_MANAGE = 'fundraisers.manage';
    public const SETTINGS_MANAGE = 'settings.manage';

    public static function grouped(): array
    {
        return [
            'Core' => [
                self::DASHBOARD_VIEW => 'Dashboard view',
                self::NOTIFICATIONS_MANAGE => 'Manage notifications',
                self::SETTINGS_MANAGE => 'Manage settings',
            ],
            'Fundraisers' => [
                self::FUNDRAISERS_MANAGE => 'Manage fundraisers',
                self::FUNDRAISER_POSTS_MANAGE => 'Manage fundraiser posts',
                self::FUNDRAISER_POSTS_MODERATE => 'Approve/Hold/Reject fundraiser posts',
            ],
            'Content' => [
                self::BLOGS_MANAGE => 'Manage blogs',
                self::EVENTS_MANAGE => 'Manage events',
                self::CATEGORIES_MANAGE => 'Manage categories',
            ],
            'Operations' => [
                self::DONATIONS_MANAGE => 'Manage donations',
                self::REPORTS_MANAGE => 'Manage reports',
                self::USERS_MANAGE => 'Manage users',
                self::RECORDS_DELETE => 'Delete records',
            ],
        ];
    }

    public static function labels(): array
    {
        return collect(self::grouped())->collapse()->all();
    }

    public static function routeMap(): array
    {
        return [
            'admin.dashboard' => self::DASHBOARD_VIEW,
            'admin.activities.*' => self::NOTIFICATIONS_MANAGE,
            'admin.fundraiser-posts.index' => self::FUNDRAISER_POSTS_MANAGE,
            'admin.fundraiser-posts.*' => self::FUNDRAISER_POSTS_MODERATE,
            'admin.fundraiser-referrals.*' => self::REPORTS_MANAGE,
            'admin.fundraiser-reports.*' => self::REPORTS_MANAGE,
            'admin.reports.*' => self::REPORTS_MANAGE,
            'admin.donations.*' => self::DONATIONS_MANAGE,
            'admin.fundraisers.*' => self::FUNDRAISERS_MANAGE,
            'admin.supporters.*' => self::DONATIONS_MANAGE,
            'admin.blogs.*' => self::BLOGS_MANAGE,
            'admin.blog-categories.*' => self::CATEGORIES_MANAGE,
            'admin.events.*' => self::EVENTS_MANAGE,
            'admin.contact-messages.*' => self::REPORTS_MANAGE,
            'admin.settings.*' => self::SETTINGS_MANAGE,
            'admin.users.*' => self::USERS_MANAGE,
        ];
    }

    public static function roles(): array
    {
        return [
            'super-admin' => [
                'name' => 'Super Admin',
                'permissions' => array_keys(self::labels()),
            ],
            'admin' => [
                'name' => 'Admin',
                'permissions' => [
                    self::DASHBOARD_VIEW,
                    self::FUNDRAISER_POSTS_MANAGE,
                    self::FUNDRAISER_POSTS_MODERATE,
                    self::DONATIONS_MANAGE,
                    self::BLOGS_MANAGE,
                    self::EVENTS_MANAGE,
                    self::REPORTS_MANAGE,
                    self::CATEGORIES_MANAGE,
                    self::NOTIFICATIONS_MANAGE,
                    self::FUNDRAISERS_MANAGE,
                ],
            ],
            'fundraiser-manager' => [
                'name' => 'Fundraiser Manager',
                'permissions' => [
                    self::DASHBOARD_VIEW,
                    self::FUNDRAISERS_MANAGE,
                    self::FUNDRAISER_POSTS_MANAGE,
                    self::FUNDRAISER_POSTS_MODERATE,
                ],
            ],
            'donation-manager' => [
                'name' => 'Donation Manager',
                'permissions' => [self::DASHBOARD_VIEW, self::DONATIONS_MANAGE],
            ],
            'blog-manager' => [
                'name' => 'Blog Manager',
                'permissions' => [self::DASHBOARD_VIEW, self::BLOGS_MANAGE, self::CATEGORIES_MANAGE],
            ],
            'event-manager' => [
                'name' => 'Event Manager',
                'permissions' => [self::DASHBOARD_VIEW, self::EVENTS_MANAGE],
            ],
            'report-manager' => [
                'name' => 'Report Manager',
                'permissions' => [self::DASHBOARD_VIEW, self::REPORTS_MANAGE],
            ],
            'support-staff' => [
                'name' => 'Support Staff',
                'permissions' => [self::DASHBOARD_VIEW, self::REPORTS_MANAGE, self::NOTIFICATIONS_MANAGE],
            ],
        ];
    }
}
