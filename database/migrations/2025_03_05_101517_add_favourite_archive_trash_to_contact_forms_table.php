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
        Schema::table('contact_forms', function (Blueprint $table) {
             $table->boolean('favourite')->default(false);  // Favourited contact
            $table->boolean('archive')->default(false);    // Archived contact
            $table->boolean('trash')->default(false);      // Trashed contact
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contact_forms', function (Blueprint $table) {
            $table->dropColumn('favourite');
            $table->dropColumn('archive');
            $table->dropColumn('trash');
        });
    }
};
