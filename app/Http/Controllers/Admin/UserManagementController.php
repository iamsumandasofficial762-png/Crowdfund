<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivity;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('search', ''));
        $role = (string) $request->query('role', '');
        $status = (string) $request->query('status', 'all');
        $allowedStatuses = array_merge(['all', 'deleted'], array_keys(User::statuses()));

        if (! in_array($status, $allowedStatuses, true)) {
            $status = 'all';
        }

        $users = User::query()
            ->with('role')
            ->when($status === 'deleted', fn ($query) => $query->onlyTrashed())
            ->when($status !== '' && $status !== 'all' && $status !== 'deleted', fn ($query) => $query->where('status', $status))
            ->when($role !== '', fn ($query) => $query->whereHas('role', fn ($query) => $query->where('slug', $role)))
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => Role::orderBy('name')->get(),
            'permissions' => Permission::orderBy('group')->orderBy('name')->get()->groupBy('group'),
            'statuses' => User::statuses(),
            'search' => $search,
            'roleFilter' => $role,
            'statusFilter' => $status,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'status' => $request->input('status') ?: User::STATUS_ACTIVE,
        ]);

        $validated = $this->validatedUser($request);
        $role = Role::findOrFail($validated['role_id']);

        $this->guardSuperAdminRole($role);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $validated['password'],
            'role_id' => $role->id,
            'status' => $validated['status'],
            'held_at' => $validated['status'] === User::STATUS_HOLD ? now() : null,
            'held_by' => $validated['status'] === User::STATUS_HOLD ? auth()->id() : null,
        ]);

        $this->syncRolePermissions($role, $request);
        $this->activity('Admin User Created', "{$user->name} was created with {$role->name} access.");

        return back()->with('status', 'User account created successfully.');
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $user->load('role');
        $request->merge([
            'status' => $request->input('status') ?: ($user->status ?: User::STATUS_ACTIVE),
        ]);

        $validated = $this->validatedUser($request, $user);
        $role = Role::findOrFail($validated['role_id']);

        $this->guardProtectedUser($user, 'update');
        $this->guardSuperAdminRole($role);

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role_id' => $role->id,
            'status' => $validated['status'],
            'held_at' => $validated['status'] === User::STATUS_HOLD ? ($user->held_at ?? now()) : null,
            'held_by' => $validated['status'] === User::STATUS_HOLD ? ($user->held_by ?? auth()->id()) : null,
        ];

        if (! empty($validated['password'])) {
            $data['password'] = $validated['password'];
        }

        $user->update($data);
        $this->syncRolePermissions($role, $request);
        $this->activity('Admin User Updated', "{$user->name} account, role, or permissions were updated.");

        return back()->with('status', 'User account updated successfully.');
    }

    public function hold(User $user): RedirectResponse
    {
        $this->guardProtectedUser($user, 'hold');

        $user->update([
            'status' => User::STATUS_HOLD,
            'held_at' => now(),
            'held_by' => auth()->id(),
        ]);

        $this->activity('Admin User Held', "{$user->name} was placed on hold.");

        return back()->with('status', 'User account placed on hold.');
    }

    public function activate(User $user): RedirectResponse
    {
        $this->guardProtectedUser($user, 'activate');

        $user->update([
            'status' => User::STATUS_ACTIVE,
            'held_at' => null,
            'held_by' => null,
        ]);

        $this->activity('Admin User Activated', "{$user->name} was activated.");

        return back()->with('status', 'User account activated.');
    }

    public function destroy(User $user): RedirectResponse
    {
        $this->guardProtectedUser($user, 'delete');

        $user->delete();
        $this->activity('Admin User Deleted', "{$user->name} was deleted.");

        return back()->with('status', 'User account deleted.');
    }

    public function restore(int $id): RedirectResponse
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $this->guardProtectedUser($user, 'restore');

        $user->restore();
        $user->update(['status' => User::STATUS_ACTIVE, 'held_at' => null, 'held_by' => null]);
        $this->activity('Admin User Restored', "{$user->name} was restored.");

        return back()->with('status', 'User account restored.');
    }

    private function validatedUser(Request $request, ?User $user = null): array
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:191', Rule::unique('users', 'email')->ignore($user?->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
            'status' => ['nullable', Rule::in(array_keys(User::statuses()))],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['exists:permissions,id'],
        ]);

        $validated['status'] = $validated['status'] ?: ($user?->status ?? User::STATUS_ACTIVE);

        return $validated;
    }

    private function syncRolePermissions(Role $role, Request $request): void
    {
        if ($role->isSuperAdmin()) {
            return;
        }

        $role->permissions()->sync($request->input('permissions', []));
    }

    private function guardProtectedUser(User $user, string $action): void
    {
        if ($user->id === auth()->id() && in_array($action, ['hold', 'delete'], true)) {
            abort(422, 'You cannot hold or delete your own account.');
        }

        if ($user->isSuperAdmin() && ! auth()->user()?->canManageSuperAdmins()) {
            abort(403, 'Only Super Admin can manage Super Admin users.');
        }

    }

    private function guardSuperAdminRole(Role $role): void
    {
        if ($role->isSuperAdmin() && ! auth()->user()?->canManageSuperAdmins()) {
            abort(403, 'Only Super Admin can create or edit Super Admin users.');
        }
    }

    private function activity(string $title, string $message): void
    {
        AdminActivity::create([
            'title' => $title,
            'message' => $message,
            'type' => 'user',
            'created_by' => auth()->user()->name ?? 'Admin',
        ]);
    }
}
