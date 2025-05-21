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
        Schema::create('post_category_post', function (Blueprint $table) {
            $table->uuid('post_id');
            $table->uuid('post_category_id');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');
            $table->foreign('post_category_id')->references('id')->on('post_categories')->onDelete('cascade');
            $table->primary(['post_id', 'post_category_id']);
            $table->unique(['post_id', 'post_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_category_post');
    }
};