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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');
            $table->integer('deal_type'); //refers product or service 1 - product,2 - service,3 - product and service
            $table->integer('category_id');
            $table->string('brand')->nullable();
            $table->longtext('description')->nullable();
            $table->string('slug')->unique();
            $table->decimal('original_price', 10, 2);
            $table->decimal('discounted_price', 10, 2);
            $table->decimal('discount_percentage', 5, 2);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('stock')->default(0)->nullable(); // Nullable for services
            $table->string('sku', 100)->unique()->nullable(); // Nullable for services
            $table->string('image_url')->nullable();
            $table->boolean('active')->default(0);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
