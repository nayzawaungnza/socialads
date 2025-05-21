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
        Schema::create('seo_meta', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('page_type'); // e.g., 'home', 'blog', 'product'
            $table->uuid('page_id')->nullable(); // Optional: Store model ID
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('robots')->default('index, follow');
            $table->json('open_graph')->nullable();
            $table->json('twitter')->nullable();
            $table->json('structured_data')->nullable();
            $table->json('alternate_links')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_meta');
    }
};
