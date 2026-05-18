<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminActivityController extends Controller
{
    public function index(): View
    {
        $activities = AdminActivity::latest()->paginate(15);

        return view('admin.activities.index', compact('activities'));
    }

    public function markAsRead(int $id): RedirectResponse
    {
        AdminActivity::findOrFail($id)->markAsRead();

        return back()->with('status', 'Activity marked as read.');
    }

    public function destroy(int $id): RedirectResponse
    {
        AdminActivity::findOrFail($id)->delete();

        return back()->with('status', 'Activity deleted.');
    }

    public function latest(): JsonResponse
    {
        return response()->json([
            'unread_count' => AdminActivity::unread()->count(),
            'activities' => AdminActivity::latest()->take(5)->get(),
        ]);
    }
}
