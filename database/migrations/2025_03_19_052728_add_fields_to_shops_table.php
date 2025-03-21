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
        Schema::table('shops', function (Blueprint $table) {
            if (!Schema::hasColumn('shops', 'shop_lattitude')) {
                $table->string('shop_lattitude')->nullable();
            }
            if (!Schema::hasColumn('shops', 'shop_longtitude')) {
                $table->string('shop_longtitude')->nullable();
            }
        });

        // Modify default value only if the column already exists
        Schema::table('shops', function (Blueprint $table) {
            $table->string('shop_lattitude')->nullable()->default('active')->change();
        });
    }

    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn(['shop_lattitude', 'shop_longtitude']);
        });
    }
};
