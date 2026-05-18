<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            if (! Schema::hasColumn('contact_messages', 'request_type')) {
                $table->string('request_type', 80)->nullable()->after('phone');
            }

            if (! Schema::hasColumn('contact_messages', 'estimated_cost')) {
                $table->string('estimated_cost', 120)->nullable()->after('request_type');
            }

            if (! Schema::hasColumn('contact_messages', 'preferred_language')) {
                $table->string('preferred_language', 80)->nullable()->after('estimated_cost');
            }

            if (! Schema::hasColumn('contact_messages', 'reason')) {
                $table->string('reason', 120)->nullable()->after('preferred_language');
            }

            if (! Schema::hasColumn('contact_messages', 'description')) {
                $table->text('description')->nullable()->after('reason');
            }

            if (! Schema::hasColumn('contact_messages', 'alternate_phone')) {
                $table->string('alternate_phone', 50)->nullable()->after('description');
            }
        });
    }

    public function down(): void
    {
        Schema::table('contact_messages', function (Blueprint $table) {
            foreach ([
                'request_type',
                'estimated_cost',
                'preferred_language',
                'reason',
                'description',
                'alternate_phone',
            ] as $column) {
                if (Schema::hasColumn('contact_messages', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
