<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fundraiser_reports', function (Blueprint $table) {
            $table->string('status')->default('under_processing')->after('supporting_document');
        });
    }

    public function down(): void
    {
        Schema::table('fundraiser_reports', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
