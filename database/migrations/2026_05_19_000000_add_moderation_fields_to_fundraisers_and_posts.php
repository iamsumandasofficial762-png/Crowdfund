<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fundraisers', function (Blueprint $table) {
            if (! Schema::hasColumn('fundraisers', 'status')) {
                $table->string('status', 20)->default('pending')->index();
            }

            if (! Schema::hasColumn('fundraisers', 'hold_reason')) {
                $table->text('hold_reason')->nullable()->after('status');
            }

            if (! Schema::hasColumn('fundraisers', 'rejected_reason')) {
                $table->text('rejected_reason')->nullable()->after('hold_reason');
            }

            if (! Schema::hasColumn('fundraisers', 'held_at')) {
                $table->timestamp('held_at')->nullable()->after('rejected_reason');
            }

            if (! Schema::hasColumn('fundraisers', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('held_at');
            }

            if (! Schema::hasColumn('fundraisers', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('rejected_at');
            }
        });

        Schema::table('fundraiser_posts', function (Blueprint $table) {
            if (! Schema::hasColumn('fundraiser_posts', 'status')) {
                $table->string('status', 20)->default('pending')->index();
            }

            if (! Schema::hasColumn('fundraiser_posts', 'hold_reason')) {
                $table->text('hold_reason')->nullable()->after('status');
            }

            if (! Schema::hasColumn('fundraiser_posts', 'rejected_reason')) {
                $table->text('rejected_reason')->nullable()->after('hold_reason');
            }

            if (! Schema::hasColumn('fundraiser_posts', 'held_at')) {
                $table->timestamp('held_at')->nullable()->after('rejected_reason');
            }

            if (! Schema::hasColumn('fundraiser_posts', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('held_at');
            }

            if (! Schema::hasColumn('fundraiser_posts', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('rejected_at');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fundraisers', function (Blueprint $table) {
            foreach (['hold_reason', 'rejected_reason', 'held_at'] as $column) {
                if (Schema::hasColumn('fundraisers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('fundraiser_posts', function (Blueprint $table) {
            foreach (['hold_reason', 'rejected_reason', 'held_at'] as $column) {
                if (Schema::hasColumn('fundraiser_posts', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
