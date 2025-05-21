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
        Schema::table('services', function (Blueprint $table) {
            $table->text('sub_title')->nullable()->after('description');
            $table->text('sub_description')->nullable()->after('description');
            $table->string('brand_title')->nullable()->after('sub_description');
            $table->text('brand_description')->nullable()->after('brand_title');
            $table->string('business_title')->nullable()->after('brand_description');
            $table->string('personalization_title')->nullable()->after('business_title');
            $table->text('personalization_description')->nullable()->after('personalization_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn([
                'sub_title',
                'sub_description',
                'brand_title',
                'brand_description',
                'business_title',
                'personalization_title',
                'personalization_description'
            ]);
        });
    }
};
