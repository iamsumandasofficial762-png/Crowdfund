<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'message')) {
                $table->text('message')->nullable()->after('amount');
            }

            if (!Schema::hasColumn('donations', 'is_private')) {
                $table->boolean('is_private')->default(false)->after('message');
            }
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (Schema::hasColumn('donations', 'is_private')) {
                $table->dropColumn('is_private');
            }

            if (Schema::hasColumn('donations', 'message')) {
                $table->dropColumn('message');
            }
        });
    }
};
