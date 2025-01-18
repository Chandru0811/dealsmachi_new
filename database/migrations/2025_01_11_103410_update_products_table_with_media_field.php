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
            $table->json('media')->after('sku');
            $table->dropColumn('image_url1');
            $table->dropColumn('image_url2');
            $table->dropColumn('image_url3');
            $table->dropColumn('image_url4');
            $table->string('varient')->nullable()->after('specifications');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
