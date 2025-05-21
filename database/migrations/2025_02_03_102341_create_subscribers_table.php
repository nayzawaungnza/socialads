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
        Schema::create('subscribers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('email')->unique(); // Email of the subscriber (must be unique)
            $table->string('name')->nullable(); // Optional name of the subscriber
            $table->timestamp('subscribed_at')->useCurrent(); // Timestamp when the subscriber joined
            $table->boolean('is_active')->default(true); // Whether the subscriber is active
            $table->uuid('created_by')->nullable();
            $table->uuid('updated_by')->nullable();
            $table->timestamps(); // Adds `created_at` and `updated_at` columns
            $table->softDeletes(); 

            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            
            $table->index(['name','email', 'subscribed_at', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscribers');
    }
};