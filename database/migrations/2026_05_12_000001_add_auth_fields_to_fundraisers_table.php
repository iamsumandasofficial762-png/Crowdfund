<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('fundraisers', 'email')) {
            Schema::table('fundraisers', function (Blueprint $table) {
                $table->string('email', 191)->nullable()->after('name');
            });
        }

        if (! Schema::hasColumn('fundraisers', 'password')) {
            Schema::table('fundraisers', function (Blueprint $table) {
                $table->string('password')->nullable()->after('email');
            });
        }
    }

    public function down(): void
    {
        Schema::table('fundraisers', function (Blueprint $table) {
            if (Schema::hasColumn('fundraisers', 'email')) {
                $table->dropColumn('email');
            }

            if (Schema::hasColumn('fundraisers', 'password')) {
                $table->dropColumn('password');
            }
        });
    }
};
