<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('requests', function (Blueprint $table) {
            $table->id();

            // Registered citizen, nullable for guest submissions
            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            // Guest information, nullable for registered citizens
            $table->string('guest_name')->nullable();
            $table->string('guest_contact')->nullable();

            // Concern details
            $table->text('concern_text');

            // Generated for guest submissions
            $table->string('reference_number')
                ->nullable()
                ->unique();

            // NLP results, initially nullable
            $table->string('category')->nullable();
            $table->decimal('confidence', 5, 4)->nullable();

            // Initial workflow status
            $table->string('status')->default('Pending');

            // Personnel assigned to handle the request
            $table->foreignId('assigned_to')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};