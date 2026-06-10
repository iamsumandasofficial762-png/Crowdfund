@php
    use App\Support\AdminPermissions;

    $adminNavItems = [
        ['route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'permission' => AdminPermissions::DASHBOARD_VIEW, 'icon' => 'fa-table-cells-large', 'label' => 'Dashboard'],
        ['route' => 'admin.fundraiser-posts.index', 'pattern' => 'admin.fundraiser-posts.*', 'permission' => AdminPermissions::FUNDRAISER_POSTS_MANAGE, 'icon' => 'fa-rectangle-list', 'label' => 'Fundraiser Posts'],
        ['route' => 'admin.fundraiser-referrals.index', 'pattern' => 'admin.fundraiser-referrals.*', 'permission' => AdminPermissions::REPORTS_MANAGE, 'icon' => 'fa-hand-holding-heart', 'label' => 'Referrals'],
        ['route' => 'admin.fundraiser-reports.index', 'pattern' => 'admin.fundraiser-reports.*', 'permission' => AdminPermissions::REPORTS_MANAGE, 'icon' => 'fa-flag', 'label' => 'Reports'],
        ['route' => 'admin.events.index', 'pattern' => 'admin.events.*', 'permission' => AdminPermissions::EVENTS_MANAGE, 'icon' => 'fa-calendar-days', 'label' => 'Events'],
        ['route' => 'admin.blogs.index', 'pattern' => 'admin.blogs.*', 'permission' => AdminPermissions::BLOGS_MANAGE, 'icon' => 'fa-newspaper', 'label' => 'Blogs'],
        ['route' => 'admin.blog-categories.index', 'pattern' => 'admin.blog-categories.*', 'permission' => AdminPermissions::CATEGORIES_MANAGE, 'icon' => 'fa-tags', 'label' => 'Blog Categories'],
        ['route' => 'admin.donations.index', 'pattern' => 'admin.donations.*', 'permission' => AdminPermissions::DONATIONS_MANAGE, 'icon' => 'fa-indian-rupee-sign', 'label' => 'Donations'],
        ['route' => 'admin.fundraisers.index', 'pattern' => 'admin.fundraisers.*', 'permission' => AdminPermissions::FUNDRAISERS_MANAGE, 'icon' => 'fa-user-tie', 'label' => 'Fundraisers'],
        ['route' => 'admin.users.index', 'pattern' => 'admin.users.*', 'permission' => AdminPermissions::USERS_MANAGE, 'icon' => 'fa-users-gear', 'label' => 'Users'],
        ['route' => 'admin.settings.index', 'pattern' => 'admin.settings.*', 'permission' => AdminPermissions::SETTINGS_MANAGE, 'icon' => 'fa-gear', 'label' => 'Settings'],
    ];
@endphp

<a class="brand d-inline-flex mb-4" href="{{ route('admin.dashboard') }}">
    <img src="{{ asset('assets/images/logo.png') }}" alt="Karna Kavach">
</a>
<nav>
    @foreach ($adminNavItems as $item)
        @if (auth()->user()?->hasPermission($item['permission']))
            <a class="nav-link {{ request()->routeIs($item['pattern']) ? 'active' : '' }}" href="{{ route($item['route']) }}">
                <i class="fa-solid {{ $item['icon'] }}"></i> {{ $item['label'] }}
            </a>
        @endif
    @endforeach
</nav>
