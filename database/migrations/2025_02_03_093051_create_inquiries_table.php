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
        Schema::create('inquiries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable(); // Optional field
            $table->string('subject');
            $table->text('message');
            $table->string('status')->default('pending'); // Default status
            $table->uuid('updated_by')->nullable();
            $table->timestamps(); // Adds `created_at` and `updated_at` columns
            $table->softDeletes();
            
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['name','email', 'subject', 'status', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inquiries');
    }
};