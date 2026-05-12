<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fundraisers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('country_code', 10)->default('+91');
            $table->string('phone', 30);
            $table->string('cause', 100);
            $table->json('documents')->nullable();
            $table->string('status', 20)->default('pending')->index();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fundraisers');
    }
};
