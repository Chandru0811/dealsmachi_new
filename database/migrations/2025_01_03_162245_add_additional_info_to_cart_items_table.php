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
        Schema::table('cart_items', function (Blueprint $table) {
            $table->decimal('shipping', 20, 6)->nullable();
            $table->decimal('packaging', 20, 6)->nullable();
            $table->decimal('handling', 20, 6)->nullable();
            $table->decimal('taxes', 20, 6)->nullable();
            $table->decimal('shipping_weight', 20, 6)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cart_items', function (Blueprint $table) {
            //
        });
    }
};
