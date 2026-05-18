<?php

use App\Models\Blog;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (! Schema::hasColumn('blogs', 'category')) {
                $table->string('category', 80)->nullable()->after('slug')->index();
            }

            if (! Schema::hasColumn('blogs', 'tags')) {
                $table->json('tags')->nullable()->after('category');
            }
        });

        Blog::query()
            ->whereNull('category')
            ->update(['category' => Blog::CATEGORY_DONATION]);
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            if (Schema::hasColumn('blogs', 'category')) {
                $table->dropIndex(['category']);
                $table->dropColumn('category');
            }

            if (Schema::hasColumn('blogs', 'tags')) {
                $table->dropColumn('tags');
            }
        });
    }
};
