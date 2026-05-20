<?php

use App\Support\AdminPermissions;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('permissions') || ! Schema::hasTable('roles') || ! Schema::hasTable('permission_role')) {
            return;
        }

        $now = now();
        $oldPermission = DB::table('permissions')->where('slug', 'users.manage')->first();
        $newPermission = DB::table('permissions')->where('slug', AdminPermissions::USERS_MANAGE)->first();

        if ($oldPermission && $newPermission) {
            DB::table('permission_role')
                ->where('permission_id', $oldPermission->id)
                ->pluck('role_id')
                ->each(function ($roleId) use ($newPermission, $now) {
                    DB::table('permission_role')->updateOrInsert(
                        ['role_id' => $roleId, 'permission_id' => $newPermission->id],
                        ['created_at' => $now, 'updated_at' => $now]
                    );
                });

            DB::table('permission_role')->where('permission_id', $oldPermission->id)->delete();

            DB::table('permissions')->where('id', $oldPermission->id)->delete();
        } elseif ($oldPermission) {
            DB::table('permissions')
                ->where('id', $oldPermission->id)
                ->update([
                    'slug' => AdminPermissions::USERS_MANAGE,
                    'name' => 'Manage users',
                    'group' => 'Operations',
                    'updated_at' => $now,
                ]);
        } elseif (! $newPermission) {
            DB::table('permissions')->insert([
                'name' => 'Manage users',
                'slug' => AdminPermissions::USERS_MANAGE,
                'group' => 'Operations',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $superAdminRoleId = DB::table('roles')->where('slug', 'super-admin')->value('id');

        if (! $superAdminRoleId) {
            return;
        }

        DB::table('permissions')->pluck('id')->each(function ($permissionId) use ($superAdminRoleId, $now) {
            DB::table('permission_role')->updateOrInsert(
                ['role_id' => $superAdminRoleId, 'permission_id' => $permissionId],
                ['created_at' => $now, 'updated_at' => $now]
            );
        });
    }

    public function down(): void
    {
        if (! Schema::hasTable('permissions')) {
            return;
        }

        DB::table('permissions')
            ->where('slug', AdminPermissions::USERS_MANAGE)
            ->update(['slug' => 'users.manage', 'updated_at' => now()]);
    }
};
