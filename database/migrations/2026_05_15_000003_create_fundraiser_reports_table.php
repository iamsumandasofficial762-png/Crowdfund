<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fundraiser_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundraiser_post_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('country_code', 8)->nullable();
            $table->string('phone')->nullable();
            $table->text('message')->nullable();
            $table->string('supporting_document')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fundraiser_reports');
    }
};
