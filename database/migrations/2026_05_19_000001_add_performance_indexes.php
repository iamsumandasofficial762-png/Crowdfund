<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->addIndexes('fundraiser_posts', [
            'fundraiser_posts_status_approved_at_index' => ['status', 'approved_at'],
            'fundraiser_posts_status_created_at_index' => ['status', 'created_at'],
            'fundraiser_posts_fundraiser_id_status_index' => ['fundraiser_id', 'status'],
            'fundraiser_posts_category_index' => ['category'],
        ]);

        $this->addIndexes('fundraisers', [
            'fundraisers_status_created_at_index' => ['status', 'created_at'],
            'fundraisers_phone_index' => ['phone'],
        ]);
        $this->addPrefixIndex('fundraisers', 'email', 'fundraisers_email_index');

        $this->addIndexes('blogs', [
            'blogs_blog_category_id_index' => ['blog_category_id'],
        ]);
        $this->addRawIndex('blogs', 'blogs_status_published_at_index', '`status`(32), `published_at`');
        $this->addPrefixIndex('blogs', 'category', 'blogs_category_index', 100);

        $this->addRawIndex('events', 'events_status_event_date_index', '`status`(32), `event_date`');
        $this->addPrefixIndex('events', 'category', 'events_category_index', 100);

        $this->addRawIndex('donations', 'donations_fundraiser_post_id_status_index', '`fundraiser_post_id`, `status`(32)');
        $this->addRawIndex('donations', 'donations_status_paid_at_index', '`status`, `paid_at`');
        $this->addPrefixIndex('donations', 'donor_email', 'donations_donor_email_index', 100);
        $this->addPrefixIndex('donations', 'donor_phone', 'donations_donor_phone_index', 50);

        $this->addRawIndex('blog_categories', 'blog_categories_status_slug_index', '`status`, `slug`(100)');
    }

    public function down(): void
    {
        foreach ([
            'fundraiser_posts' => [
                'fundraiser_posts_status_approved_at_index',
                'fundraiser_posts_status_created_at_index',
                'fundraiser_posts_fundraiser_id_status_index',
                'fundraiser_posts_category_index',
            ],
            'fundraisers' => [
                'fundraisers_status_created_at_index',
                'fundraisers_email_index',
                'fundraisers_phone_index',
            ],
            'blogs' => [
                'blogs_status_published_at_index',
                'blogs_category_index',
                'blogs_blog_category_id_index',
            ],
            'events' => [
                'events_status_event_date_index',
                'events_category_index',
            ],
            'donations' => [
                'donations_fundraiser_post_id_status_index',
                'donations_status_paid_at_index',
                'donations_donor_email_index',
                'donations_donor_phone_index',
            ],
            'blog_categories' => [
                'blog_categories_status_slug_index',
            ],
        ] as $table => $indexes) {
            if (! Schema::hasTable($table)) {
                continue;
            }

            Schema::table($table, function (Blueprint $table) use ($indexes) {
                foreach ($indexes as $index) {
                    try {
                        $table->dropIndex($index);
                    } catch (Throwable) {
                        //
                    }
                }
            });
        }
    }

    private function addIndexes(string $table, array $indexes): void
    {
        if (! Schema::hasTable($table)) {
            return;
        }

        Schema::table($table, function (Blueprint $blueprint) use ($table, $indexes) {
            foreach ($indexes as $name => $columns) {
                if ($this->hasIndex($table, $name) || ! $this->hasColumns($table, $columns)) {
                    continue;
                }

                $blueprint->index($columns, $name);
            }
        });
    }

    private function hasColumns(string $table, array $columns): bool
    {
        foreach ($columns as $column) {
            if (! Schema::hasColumn($table, $column)) {
                return false;
            }
        }

        return true;
    }

    private function hasIndex(string $table, string $index): bool
    {
        $database = DB::getDatabaseName();

        return DB::table('information_schema.statistics')
            ->where('table_schema', $database)
            ->where('table_name', $table)
            ->where('index_name', $index)
            ->exists();
    }

    private function addPrefixIndex(string $table, string $column, string $index, int $length = 191): void
    {
        if (! Schema::hasTable($table) || ! Schema::hasColumn($table, $column) || $this->hasIndex($table, $index)) {
            return;
        }

        DB::statement(sprintf(
            'CREATE INDEX `%s` ON `%s` (`%s`(%d))',
            $index,
            $table,
            $column,
            $length
        ));
    }

    private function addRawIndex(string $table, string $index, string $columns): void
    {
        if (! Schema::hasTable($table) || $this->hasIndex($table, $index)) {
            return;
        }

        DB::statement(sprintf('CREATE INDEX `%s` ON `%s` (%s)', $index, $table, $columns));
    }
};
