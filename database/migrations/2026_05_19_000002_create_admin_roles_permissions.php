<?php

use App\Support\AdminPermissions;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('slug', 120)->unique();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 160);
            $table->string('slug', 160)->unique();
            $table->string('group', 80)->nullable()->index();
            $table->timestamps();
        });

        Schema::create('permission_role', function (Blueprint $table) {
            $table->foreignId('permission_id')->constrained()->cascadeOnDelete();
            $table->foreignId('role_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->primary(['permission_id', 'role_id']);
        });

        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 30)->nullable()->after('email');
            }

            if (! Schema::hasColumn('users', 'role_id')) {
                $table->foreignId('role_id')->nullable()->after('password')->constrained('roles')->nullOnDelete();
            }

            if (! Schema::hasColumn('users', 'status')) {
                $table->string('status', 20)->default('active')->index()->after('role_id');
            }

            if (! Schema::hasColumn('users', 'held_at')) {
                $table->timestamp('held_at')->nullable()->after('status');
            }

            if (! Schema::hasColumn('users', 'held_by')) {
                $table->foreignId('held_by')->nullable()->after('held_at')->constrained('users')->nullOnDelete();
            }

            if (! Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes()->after('updated_at');
            }
        });

        $this->seedRolesAndPermissions();
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            foreach (['held_by'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropConstrainedForeignId($column);
                }
            }

            if (Schema::hasColumn('users', 'role_id')) {
                $table->dropConstrainedForeignId('role_id');
            }

            foreach (['phone', 'status', 'held_at', 'deleted_at'] as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('roles');
    }

    private function seedRolesAndPermissions(): void
    {
        $now = now();
        $permissionIds = [];

        foreach (AdminPermissions::grouped() as $group => $permissions) {
            foreach ($permissions as $slug => $name) {
                DB::table('permissions')->updateOrInsert(
                    ['slug' => $slug],
                    ['name' => $name, 'group' => $group, 'created_at' => $now, 'updated_at' => $now]
                );
                $permissionIds[$slug] = DB::table('permissions')->where('slug', $slug)->value('id');
            }
        }

        foreach (AdminPermissions::roles() as $slug => $roleData) {
            DB::table('roles')->updateOrInsert(
                ['slug' => $slug],
                ['name' => $roleData['name'], 'description' => null, 'created_at' => $now, 'updated_at' => $now]
            );

            $roleId = DB::table('roles')->where('slug', $slug)->value('id');
            foreach ($roleData['permissions'] as $permissionSlug) {
                DB::table('permission_role')->updateOrInsert(
                    ['role_id' => $roleId, 'permission_id' => $permissionIds[$permissionSlug]],
                    ['created_at' => $now, 'updated_at' => $now]
                );
            }
        }

        $superAdminRoleId = DB::table('roles')->where('slug', 'super-admin')->value('id');

        if (! DB::table('users')->exists()) {
            DB::table('users')->insert([
                'name' => 'Super Admin',
                'email' => 'admin@example.com',
                'phone' => null,
                'password' => Hash::make('password'),
                'role_id' => $superAdminRoleId,
                'status' => 'active',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        DB::table('users')
            ->whereNull('role_id')
            ->orderBy('id')
            ->limit(1)
            ->update(['role_id' => $superAdminRoleId, 'status' => 'active']);
    }
};
