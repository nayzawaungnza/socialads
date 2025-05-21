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
        Schema::create('config_settings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('site_name')->nullable(); // Website name
            $table->string('site_logo')->nullable(); // Path or URL to the logo
            $table->string('favicon')->nullable(); // Path or URL to the favicon
            $table->string('contact_email')->nullable(); // Contact email address
            $table->string('contact_phone')->nullable(); // Contact phone number
            $table->text('address')->nullable(); // Physical address
            
            $table->string('facebook_url')->nullable(); // Facebook URL
            $table->string('twitter_url')->nullable(); // Twitter URL
            $table->string('youtube_url')->nullable(); // YouTube URL
            $table->string('instagram_url')->nullable(); // Instagram URL
            $table->string('linkedin_url')->nullable(); // LinkedIn URL
            $table->text('meta_description')->nullable(); // Meta description for SEO
            $table->text('meta_keywords')->nullable(); // Meta keywords for SEO
            $table->text('copyright_text')->nullable(); // Copyright text
            $table->string('timezone')->default('UTC'); // Default timezone
            $table->boolean('maintenance_mode')->default(false); // Maintenance mode flag
            $table->timestamps(); // Adds `created_at` and `updated_at` columns

             // Google Maps Columns
             $table->string('google_maps_api_key')->nullable(); // Google Maps API key
             $table->decimal('latitude', 10, 8)->nullable(); // Latitude for map location
             $table->decimal('longitude', 11, 8)->nullable(); // Longitude for map location
             $table->text('google_maps_embed_url')->nullable(); // Embedded Google Maps URL
            
             $table->uuid('updated_by')->nullable();
             $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
            
             $table->index(['site_name', 'created_at']);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('config_settings');
    }
};