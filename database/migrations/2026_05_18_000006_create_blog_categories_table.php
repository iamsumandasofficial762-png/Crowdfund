<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('blog_categories')) {
            DB::statement('ALTER TABLE blog_categories MODIFY slug VARCHAR(191) NOT NULL');
            Schema::table('blog_categories', function (Blueprint $table) {
                $table->unique('slug');
            });
        } else {
            Schema::create('blog_categories', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug', 191)->unique();
                $table->boolean('status')->default(true)->index();
                $table->timestamps();
            });
        }

        $categories = collect([
            'Donation',
            'Charity',
            'Volunteer',
            'Health',
            'Education',
        ]);

        if (Schema::hasTable('blogs') && Schema::hasColumn('blogs', 'category')) {
            $categories = $categories
                ->merge(DB::table('blogs')->whereNotNull('category')->pluck('category'))
                ->filter()
                ->unique(fn (string $category) => Str::slug($category));
        }

        $now = now();

        $categories->each(function (string $category) use ($now) {
            $slug = Str::slug($category);

            if ($slug === '') {
                return;
            }

            DB::table('blog_categories')->updateOrInsert(
                ['slug' => $slug],
                [
                    'name' => Str::headline($category),
                    'status' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
