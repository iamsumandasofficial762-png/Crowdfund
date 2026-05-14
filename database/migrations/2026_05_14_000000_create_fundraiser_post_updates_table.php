<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fundraiser_post_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundraiser_post_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->longText('update_text');
            $table->string('update_image')->nullable();
            $table->boolean('is_published')->default(true)->index();
            $table->timestamps();

            $table->index(['fundraiser_post_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fundraiser_post_updates');
    }
};
