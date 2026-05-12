<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fundraiser_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundraiser_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('short_description', 500);
            $table->longText('full_description');
            $table->decimal('goal_amount', 12, 2);
            $table->decimal('raised_amount', 12, 2)->default(0);
            $table->string('category', 100);
            $table->string('beneficiary_name');
            $table->string('beneficiary_phone', 30);
            $table->string('location');
            $table->string('main_image')->nullable();
            $table->string('supporting_file')->nullable();
            $table->string('status', 20)->default('pending')->index();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fundraiser_posts');
    }
};
