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
            Schema::table('shops', function (Blueprint $table) {
                $table->string('company_registeration_no')->after('legal_name');
                $table->string('city')->nullable()->change();
                $table->string('state')->nullable()->change();
                $table->decimal('shop_ratings')->nullable()->default(0)->change();
                $table->boolean('active')->nullable()->default(1)->change();
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shops', function (Blueprint $table) {
            //
        });
    }
};
