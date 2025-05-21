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
        Schema::table('config_settings', function (Blueprint $table) {
            $table->string('tiktok_url')->nullable()->after('linkedin_url');
            $table->string('whatsapp_url')->nullable()->after('tiktok_url');
            $table->string('viber')->nullable()->after('whatsapp_url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('config_settings', function (Blueprint $table) {
            $table->dropColumn(['tiktok_url', 'whatsapp_url', 'viber']);
        });
    }
};