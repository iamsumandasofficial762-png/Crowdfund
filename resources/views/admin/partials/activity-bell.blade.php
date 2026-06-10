<style>
    .activity-dropdown { position:relative; }
    .activity-bell-btn { width:42px; height:42px; position:relative; display:inline-flex; align-items:center; justify-content:center; border:1px solid var(--line, #dde2ea); border-radius:999px; color:var(--ink, #071226); background:#fff; box-shadow:0 4px 12px rgba(18,24,39,.06); }
    .activity-bell-btn:hover,.activity-bell-btn:focus,.activity-bell-btn.show { border-color:rgba(147,42,25,.75); color:#932a19; background:#f7e1df; }
    .activity-badge { min-width:19px; height:19px; position:absolute; top:-5px; right:-4px; display:inline-flex; align-items:center; justify-content:center; border-radius:999px; padding:0 5px; color:#fff; background:#b42318; font-size:11px; font-weight:900; line-height:1; }
    .activity-menu { width:min(380px, calc(100vw - 28px)); border:1px solid var(--line, #dde2ea); border-radius:16px; padding:0; overflow:hidden; box-shadow:0 18px 42px rgba(18,24,39,.16); }
    .activity-menu__head,.activity-menu__foot { display:flex; align-items:center; justify-content:space-between; gap:12px; padding:14px 16px; background:#fff; }
    .activity-menu__head { border-bottom:1px solid var(--line, #dde2ea); }
    .activity-menu__head strong { font-weight:900; }
    .activity-menu__body { max-height:360px; overflow:auto; background:#fff; }
    .activity-item { display:block; padding:13px 16px; border-bottom:1px solid #eef1f5; color:var(--ink, #071226); background:#fff; }
    .activity-item.is-unread { background:#fff7f5; }
    .activity-item strong { display:block; margin-bottom:3px; font-size:14px; font-weight:900; }
    .activity-item p { margin:0 0 6px; color:#647083; font-size:13px; line-height:1.45; }
    .activity-item time { color:#7b8494; font-size:12px; font-weight:800; }
    .activity-menu__empty { padding:22px 16px; color:#647083; text-align:center; font-weight:800; }
    .activity-menu__foot { border-top:1px solid var(--line, #dde2ea); }
    .activity-menu__foot a { color:#932a19; font-weight:900; text-decoration:underline; }
</style>

<div class="dropdown activity-dropdown">
    <button class="activity-bell-btn" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" aria-label="Admin notifications">
        <i class="fa-solid fa-bell"></i>
        @if (($unreadAdminActivityCount ?? 0) > 0)
            <span class="activity-badge">{{ $unreadAdminActivityCount > 99 ? '99+' : $unreadAdminActivityCount }}</span>
        @endif
    </button>
    <div class="dropdown-menu dropdown-menu-end activity-menu">
        <div class="activity-menu__head">
            <strong>Notifications</strong>
            <span class="badge badge-gold">{{ number_format($unreadAdminActivityCount ?? 0) }} unread</span>
        </div>
        <div class="activity-menu__body">
            @forelse (($latestAdminActivities ?? collect()) as $activity)
                @if(is_object($activity) && method_exists($activity, 'getAttribute'))
                    <a class="activity-item {{ $activity->is_read ? '' : 'is-unread' }}" href="{{ route('admin.activities.index') }}">
                        <strong>{{ $activity->title }}</strong>
                        <p>{{ \Illuminate\Support\Str::limit($activity->message, 92) }}</p>
                        <time>{{ $activity->created_at->diffForHumans() }}</time>
                    </a>
                @endif
            @empty
                <div class="activity-menu__empty">No activities yet.</div>
            @endforelse
        </div>
        <div class="activity-menu__foot">
            <span>Showing {{ number_format(($latestAdminActivities ?? collect())->count()) }} latest</span>
            <a href="{{ route('admin.activities.index') }}">View All</a>
        </div>
    </div>
</div>
