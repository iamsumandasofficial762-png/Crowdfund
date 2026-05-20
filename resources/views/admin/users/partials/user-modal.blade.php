@php
    $selectedRole = old('role_id', $user?->role_id);
    $selectedStatus = old('status', $user?->status ?? \App\Models\User::STATUS_ACTIVE);
    $selectedPermissions = collect(old('permissions', $user?->role?->permissions?->pluck('id')->all() ?? []))->map(fn ($id) => (int) $id)->all();
@endphp

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <form class="modal-content" action="{{ $formAction }}" method="post">
            @csrf
            @if ($method !== 'POST')
                @method($method)
            @endif
            <div class="modal-header border-0">
                <h2 class="modal-title h5 fw-bold">{{ $user ? 'Edit User' : 'Create User' }}</h2>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-0">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Name</label>
                        <input class="form-control" name="name" value="{{ old('name', $user?->name) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Email</label>
                        <input class="form-control" type="email" name="email" value="{{ old('email', $user?->email) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Phone</label>
                        <input class="form-control" name="phone" value="{{ old('phone', $user?->phone) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Password</label>
                        <input class="form-control" type="password" name="password" autocomplete="new-password" {{ $user ? '' : 'required' }}>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Confirm Password</label>
                        <input class="form-control" type="password" name="password_confirmation" autocomplete="new-password" {{ $user ? '' : 'required' }}>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Job Role</label>
                        <select class="form-select" name="role_id" required>
                            @foreach ($roles as $role)
                                @continue($role->isSuperAdmin() && ! auth()->user()?->canManageSuperAdmins())
                                <option value="{{ $role->id }}" @selected((int) $selectedRole === $role->id)>{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <select class="form-select" name="status" required>
                            @foreach ($statuses as $key => $label)
                                <option value="{{ $key }}" @selected($selectedStatus === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-bold">Access Permissions</label>
                        <div class="permission-grid">
                            @foreach ($permissions as $group => $items)
                                <div class="permission-group">
                                    <h4>{{ $group ?: 'General' }}</h4>
                                    @foreach ($items as $permission)
                                        <label class="permission-option">
                                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" @checked(in_array($permission->id, $selectedPermissions, true))>
                                            <span>{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button class="btn btn-light fw-bold" type="button" data-bs-dismiss="modal">Cancel</button>
                <button class="btn-admin btn-create" type="submit">{{ $user ? 'Save Changes' : 'Create User' }}</button>
            </div>
        </form>
    </div>
</div>
