<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('events')) {
            DB::statement("ALTER TABLE events MODIFY status VARCHAR(32) NOT NULL DEFAULT 'draft'");

            try {
                Schema::table('events', function (Blueprint $table) {
                    $table->index('status');
                });
            } catch (\Throwable) {
                //
            }

            return;
        }

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug', 191)->unique();
            $table->text('short_description')->nullable();
            $table->longText('full_description')->nullable();
            $table->string('event_image')->nullable();
            $table->date('event_date')->nullable()->index();
            $table->time('event_time')->nullable();
            $table->string('location')->nullable();
            $table->string('organizer_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('status', 32)->default('draft')->index();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
