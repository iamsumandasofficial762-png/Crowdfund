<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fundraiser_post_id')->constrained()->cascadeOnDelete();
            $table->string('donor_name');
            $table->string('donor_email')->nullable();
            $table->string('donor_phone')->nullable();
            $table->decimal('amount', 12, 2);
            $table->string('payment_method')->nullable();
            $table->string('status', 30)->default('paid');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['fundraiser_post_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
