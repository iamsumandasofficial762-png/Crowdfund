<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fundraiser_referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundraiser_post_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->string('country_code', 10)->default('+91');
            $table->string('phone', 30);
            $table->string('reason');
            $table->string('estimated_cost');
            $table->string('preferred_language');
            $table->string('alternate_country_code', 10)->nullable();
            $table->string('alternate_phone', 30)->nullable();
            $table->string('status', 30)->default('new')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fundraiser_referrals');
    }
};
