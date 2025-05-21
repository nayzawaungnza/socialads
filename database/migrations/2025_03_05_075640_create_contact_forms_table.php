<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contact_forms', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name'); // Contact Name
            $table->string('email'); // Email
            $table->string('phone')->nullable(); // Phone (nullable)
            $table->string('subject'); // Subject of the message
            $table->enum('type', ['general', 'support', 'feedback'])->default('general'); // Message type
            $table->text('message'); // The message content
            $table->enum('status', ['new', 'read', 'resolved'])->default('new'); // Status of the message
            $table->boolean('mark_as_read')->default(false);
            $table->uuid('updated_by')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            $table->index(['name','email','phone', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_forms');
    }
};
