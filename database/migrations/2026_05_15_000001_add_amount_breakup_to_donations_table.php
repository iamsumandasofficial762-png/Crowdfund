<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            if (!Schema::hasColumn('donations', 'main_amount')) {
                $table->decimal('main_amount', 12, 2)->default(0)->after('amount');
            }

            if (!Schema::hasColumn('donations', 'tip_amount')) {
                $table->decimal('tip_amount', 12, 2)->default(0)->after('main_amount');
            }

            if (!Schema::hasColumn('donations', 'tip_percent')) {
                $table->unsignedTinyInteger('tip_percent')->default(0)->after('tip_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('donations', function (Blueprint $table) {
            foreach (['tip_percent', 'tip_amount', 'main_amount'] as $column) {
                if (Schema::hasColumn('donations', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
