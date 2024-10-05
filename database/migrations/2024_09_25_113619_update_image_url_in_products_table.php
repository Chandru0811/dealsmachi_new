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
        Schema::table('products', function (Blueprint $table) {
            // Rename image_url to image_url1
            $table->renameColumn('image_url', 'image_url1');

            // Add new image columns
            $table->string('image_url2')->nullable()->after('image_url1');
            $table->string('image_url3')->nullable()->after('image_url2');
            $table->string('image_url4')->nullable()->after('image_url3');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert the column name change
            $table->renameColumn('image_url1', 'image_url');

            // Drop the newly added columns
            $table->dropColumn(['image_url2', 'image_url3', 'image_url4']);
        });
    }
};
