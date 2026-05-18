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
        Schema::table('blogs', function (Blueprint $table) {
            if (! Schema::hasColumn('blogs', 'blog_category_id')) {
                $table->foreignId('blog_category_id')
                    ->nullable()
                    ->after('category')
                    ->constrained('blog_categories')
                    ->nullOnDelete();
            }
        });

        if (Schema::hasColumn('blogs', 'category')) {
            DB::table('blogs')
                ->whereNotNull('category')
                ->orderBy('id')
                ->get(['id', 'category'])
                ->each(function ($blog) {
                    $categoryId = DB::table('blog_categories')
                        ->where('slug', Str::slug($blog->category))
                        ->value('id');

                    if ($categoryId) {
                        DB::table('blogs')
                            ->where('id', $blog->id)
                            ->update(['blog_category_id' => $categoryId]);
                    }
                });
        }
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (Schema::hasColumn('blogs', 'blog_category_id')) {
                $table->dropConstrainedForeignId('blog_category_id');
            }
        });
    }
};
