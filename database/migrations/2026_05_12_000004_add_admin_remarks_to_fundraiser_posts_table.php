<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fundraiser_posts', function (Blueprint $table) {
            if (! Schema::hasColumn('fundraiser_posts', 'admin_remarks')) {
                $table->text('admin_remarks')->nullable()->after('rejected_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fundraiser_posts', function (Blueprint $table) {
            if (Schema::hasColumn('fundraiser_posts', 'admin_remarks')) {
                $table->dropColumn('admin_remarks');
            }
        });
    }
};
