<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('blogs')) {
            DB::statement('ALTER TABLE blogs MODIFY slug VARCHAR(191) NOT NULL');
            Schema::table('blogs', function (Blueprint $table) {
                $table->unique('slug');
            });

            return;
        }

        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug', 191)->unique();
            $table->text('short_description')->nullable();
            $table->longText('full_description');
            $table->string('featured_image')->nullable();
            $table->string('status')->default('draft')->index();
            $table->timestamp('published_at')->nullable()->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
