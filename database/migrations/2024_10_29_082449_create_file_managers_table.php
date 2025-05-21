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
        Schema::create('file_managers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('resourceable_type')->index();  // Add index for faster lookup
            $table->uuid('resourceable_id')->index();       // Add index for faster lookup
            $table->string('file_name');                    // Added file_name for description
            $table->string('file_url')->nullable();
            $table->string('file_type')->nullable();        // Added file_type to specify type (e.g., pdf, jpg)
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_managers');
    }
};