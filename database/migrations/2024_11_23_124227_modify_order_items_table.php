<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Rename `product_id` to `deal_id`
            $table->renameColumn('product_id', 'deal_id');

            // Add `deal_name` column after `deal_id`
            $table->string('deal_name')->after('deal_id');

            // Rename `unit_price` to `deal_originalprice`
            $table->renameColumn('unit_price', 'deal_originalprice');

            // Rename `item_description` to `deal_description`
            $table->renameColumn('item_description', 'deal_description');

            // Add extra columns after existing ones
            $table->decimal('deal_price', 20, 6)->after('deal_originalprice');
            $table->decimal('discount_percentage', 5, 2)->after('deal_price');
            $table->string('coupon_code')->nullable()->after('discount_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Reverse the column renames
            $table->renameColumn('deal_id', 'product_id');
            $table->renameColumn('deal_originalprice', 'unit_price');
            $table->renameColumn('deal_description', 'item_description');

            // Drop the new columns
            $table->dropColumn('deal_name');
            $table->dropColumn('deal_price');
            $table->dropColumn('discount_percentage');
            $table->dropColumn('coupon_code');
        });
    }
}
